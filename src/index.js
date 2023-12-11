import dotenv from 'dotenv';
import express from 'express';
import { google } from 'googleapis';
import dayjs from 'dayjs';
import { fileURLToPath } from 'url';
import path from 'path';
import session from 'express-session';
import moment from 'moment-timezone';
import cors from 'cors';
import { createProxyMiddleware } from 'http-proxy-middleware';

dotenv.config();

const app = express();
const PORT = process.env.PORT || 8000;
const BASE_URL = process.env.BASE_URL || `http://localhost:${PORT}`;

// Enable CORS for all routes
app.use(cors());

// Google Calendar API setup
const calendar = google.calendar('v3');

// OAuth2 client setup
const oauth2Client = new google.auth.OAuth2(
    process.env.CLIENT_ID,
    process.env.CLIENT_SECRET,
    process.env.REDIRECT_URL
);

// Session setup
app.use(session({
    secret: 'secret',
    resave: false,
    saveUninitialized: true,
    cookie: { secure: false } // Set to true if using https
}));

// Middleware to check if the user is authenticated
const isAuthenticated = (req, res, next) => {
    if (req.session.tokens) {
        oauth2Client.setCredentials(req.session.tokens);
        next();
    } else {
        res.redirect('/google');
    }
};

// Middleware to parse JSON body
app.use(express.json());

// Serve static files
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
app.use(express.static(path.join(__dirname, 'public')));

// Google OAuth2 authentication URL
app.get('/google', (req, res) => {
    const url = oauth2Client.generateAuthUrl({
        access_type: 'online',
        scope: ['https://www.googleapis.com/auth/calendar'],
        prompt: 'consent'
    });
    res.redirect(url);
});

// Handling OAuth2 redirection
app.get('/google/redirect', async (req, res) => {
    const { code } = req.query;
    try {
        const { tokens } = await oauth2Client.getToken(code);
        req.session.tokens = tokens; // Store tokens in session
        res.redirect('/check_taskbird_calendar');
    } catch (error) {
        console.error('Error during login:', error);
        res.status(500).send('Authentication failed');
    }
});

// Check if TaskBird calendar exists or create it
app.get('/check_taskbird_calendar', isAuthenticated, async (req, res) => {
    try {
        const calendars = await calendar.calendarList.list({ auth: oauth2Client });
        let taskBirdCalendar = calendars.data.items.find(cal => cal.summary === 'TaskBird');

        if (!taskBirdCalendar) {
            const newCalendar = await calendar.calendars.insert({
                auth: oauth2Client,
                requestBody: {
                    summary: 'TaskBird',
                    description: 'Calendar for TaskBird app events',
                    timeZone: 'America/New_York'
                }
            });
            taskBirdCalendar = newCalendar.data;
        }

        req.session.taskBirdCalendarId = taskBirdCalendar.id; // Store TaskBird calendar ID in session
        res.redirect('/loading.html');
    } catch (error) {
        console.error('Error checking TaskBird calendar:', error);
        res.status(500).send('Failed to check TaskBird calendar');
    }
});

// Fetch events from TaskBird calendar for a specific month
app.get('/get_events', isAuthenticated, async (req, res) => {
    const { year, month } = req.query;
    const timeMin = new Date(year, month, 1).toISOString();
    const timeMax = new Date(year, parseInt(month) + 1, 0).toISOString();

    try {
        const { taskBirdCalendarId } = req.session;
        const events = await calendar.events.list({
            auth: oauth2Client,
            calendarId: taskBirdCalendarId,
            timeMin: timeMin,
            timeMax: timeMax,
            maxResults: 250, // Adjust as needed
            singleEvents: true,
            orderBy: 'startTime'
        });
        // Log the events to the console
        //console.log(`Fetched ${events.data.items.length} events:`, events.data.items);
        res.header("Access-Control-Allow-Origin", `${BASE_URL}/frontend`);
        res.header("Access-Control-Allow-Origin", `${BASE_URL}/home`);
        res.json(events.data.items);
    } catch (error) {
        console.error('Error fetching events:', error);
        res.status(500).send('Failed to fetch events');
    }
});

// Fetch events from TaskBird calendar for a specific day
app.get('/get_events_day', isAuthenticated, async (req, res) => {
    const { year, month, day } = req.query;
    const timeMin = day ? new Date(year, month, day).toISOString() : new Date(year, month, 1).toISOString();
    const timeMax = day ? new Date(year, month, parseInt(day) + 1).toISOString() : new Date(year, parseInt(month) + 1, 0).toISOString();

    try {
        const { taskBirdCalendarId } = req.session;
        const events = await calendar.events.list({
            auth: oauth2Client,
            calendarId: taskBirdCalendarId,
            timeMin: timeMin,
            timeMax: timeMax,
            maxResults: 250, // Adjust as needed
            singleEvents: true,
            orderBy: 'startTime'
        });

        res.json(events.data.items);
    } catch (error) {
        console.error('Error fetching events:', error);
        res.status(500).send('Failed to fetch events');
    }
});

// Endpoint to add an event to the Google Calendar
app.post('/add_event', isAuthenticated, async (req, res) => {
    console.log('Received request:', req.body);
    const { summary, location, description, start, end } = req.body;

    const formattedStartDateTime = new Date(start.dateTime).toISOString();
    const formattedEndDateTime = new Date(end.dateTime).toISOString();

    const event = {
        summary,
        location,
        description,
        start: { dateTime: formattedStartDateTime, timeZone: start.timeZone },
        end: { dateTime: formattedEndDateTime, timeZone: end.timeZone }
    };

    try {
        const { taskBirdCalendarId } = req.session; // Use the stored calendar ID from the session

        const response = await calendar.events.insert({
            calendarId: taskBirdCalendarId,
            auth: oauth2Client,
            resource: event
        });

        res.status(200).json(response.data);
    } catch (error) {
        console.error('Error adding event:', error);
        res.status(500).send('Failed to add event');
    }
});

// Endpoint to delete an event from the Google Calendar
app.post('/delete_event', isAuthenticated, async (req, res) => {
    const { eventId } = req.body;

    try {
        const { taskBirdCalendarId } = req.session; // Use the stored calendar ID from the session

        const response = await calendar.events.delete({
            calendarId: taskBirdCalendarId,
            eventId: eventId,
            auth: oauth2Client
        });

        res.status(200).json({ message: 'Event deleted successfully', deletedEvent: response.data });
    } catch (error) {
        console.error('Error deleting event:', error);
        res.status(500).send('Failed to delete event');
    }
});

// Serve HTML page with frontend JavaScript
app.get('/frontend', isAuthenticated, (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// Serve HTML page with frontend JavaScript for home
app.get('/home', isAuthenticated, (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'home.html'));
});

// Serve HTML page with login
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'login.html'));
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server started on PORT ${PORT}`);
});
