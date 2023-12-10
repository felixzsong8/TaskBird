const daysTag = document.querySelector(".days");
const currentDate = document.querySelector(".current-date");
const prevIcon = document.querySelector('.material-symbols-rounded:first-child');
const nextIcon = document.querySelector('.material-symbols-rounded:last-child');

let date = new Date();
let currYear = date.getFullYear();
let currMonth = date.getMonth();
const BASE_URL = window.location.origin;
console.log(BASE_URL);


const months = ["January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"];

async function fetchEventsForMonth(year, month) {
    const response = await fetch(`${BASE_URL}/get_events?year=${year}&month=${month}`);
    const events = await response.json();
    return events.map(event => new Date(event.start.dateTime || event.start.date).getDate());
}

async function fetchEventsForDay(year, month, day) {
    const response = await fetch(`${BASE_URL}/get_events_day?year=${year}&month=${month}&day=${day}`);
    const events = await response.json();
    return events;
}

const renderCalendar = async () => {
    const firstDayOfMonth = new Date(currYear, currMonth, 1).getDay();
    const lastDateOfMonth = new Date(currYear, currMonth + 1, 0).getDate();
    const lastDayOfMonth = new Date(currYear, currMonth, lastDateOfMonth).getDay();
    const lastDateOfLastMonth = new Date(currYear, currMonth, 0).getDate();
    let liTag = "";
    console.log(10);
    const eventDates = await fetchEventsForMonth(currYear, currMonth);

    for (let i = firstDayOfMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateOfLastMonth - i + 1}</li>`;
    }
    console.log(11);
    for (let i = 1; i <= lastDateOfMonth; i++) {
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear() ? "active" : "";
        let hasEvent = eventDates.includes(i);
        let eventDot = hasEvent ? '<span class="event-dot"></span>' : '';
        liTag += `<li class="${isToday}" data-day="${i}">${i}${eventDot}</li>`;
    }
    console.log(12);
    for (let i = lastDayOfMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayOfMonth + 1}</li>`;
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
    formattedCurrentDate = `${months[currMonth]} ${currYear}`;
    const eventDetailsHeader = document.querySelector('.event-details h2');
    eventDetailsHeader.innerText = `${formattedCurrentDate} Events`;
    console.log(13);
    const dayElements = document.querySelectorAll('.days li');
    dayElements.forEach((dayElement) => {
        dayElement.addEventListener('click', handleDayClick);
    });
};

function handleDayClick(event) {
    const clickedDay = event.target.dataset.day;
    const formattedDate = `${currYear}-${(currMonth + 1).toString().padStart(2, '0')}-${clickedDay.toString().padStart(2, '0')}`;

    fetchEventsForDay(currYear, currMonth, clickedDay).then(events => {
        const eventList = document.getElementById('eventList');
        eventList.innerHTML = '';

        events.forEach(event => {
            const li = document.createElement('li');
            li.textContent = `${event.summary} - ${new Date(event.start.dateTime).toLocaleTimeString()} to ${new Date(event.end.dateTime).toLocaleTimeString()}`;
            
            const deleteButton = createDeleteButton(event.id);
            li.appendChild(deleteButton);
            
            // Append the list item to the event list
            eventList.appendChild(li);
        });
    }).catch(error => {
        console.error('Error fetching events for day:', error);
    });
}

prevIcon.addEventListener('click', () => {
    currMonth = currMonth - 1;
    handleMonthChange();
});

nextIcon.addEventListener('click', () => {
    currMonth = currMonth + 1;
    handleMonthChange();
});

function handleMonthChange() {
    if (currMonth < 0 || currMonth > 11) {
        date = new Date(currYear, currMonth, new Date().getDate());
        currYear = date.getFullYear();
        currMonth = date.getMonth();
    } else {
        date = new Date();
    }

    renderCalendar();
}

function createDeleteButton(eventId) {
    const button = document.createElement('button');
    button.textContent = 'Delete';
    button.eventId = eventId;
    button.addEventListener('click', () => handleDeleteClick(button.eventId));
    return button;
}

async function handleDeleteClick(eventId) {
    try {
        const response = await fetch(`${BASE_URL}/delete_event`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ eventId })
        });
    
        if (response.ok) {
            const result = await response.json();
            console.log('Event deleted:', result.deletedEvent);
        } else {
            console.error('Failed to delete event');
        }
    } catch (error) {
        console.error('Error deleting event:', error);
    }
    window.location.reload();

}

document.addEventListener('DOMContentLoaded', function() {
    const eventForm = document.getElementById('eventForm');

    eventForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const summary = document.getElementById('summary').value;
        const location = document.getElementById('location').value;
        const description = document.getElementById('description').value;
        const startDateTime = document.getElementById('startDateTime').value;
        const endDateTime = document.getElementById('endDateTime').value;

        const event = {
            summary,
            location,
            description,
            start: { dateTime: startDateTime, timeZone: 'America/New_York' },
            end: { dateTime: endDateTime, timeZone: 'America/New_York' }
        };

        try {
            const response = await fetch(`${BASE_URL}/add_event`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(event)
            });

            if (response.ok) {
                const result = await response.json();
                console.log('Event added:', result);
                window.location.reload();
            } else {
                console.error('Failed to add event');
            }
        } catch (error) {
            console.error('Error submitting event:', error);
        }
    });
});
renderCalendar();
