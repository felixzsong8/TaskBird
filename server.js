const express = require('express');
const bodyParser = require('body-parser');
const { MongoClient } = require('mongodb');

const app = express();
const port = 3000; // You can choose any available port

app.use(bodyParser.json());

// MongoDB connection information
const uri = "mongodb+srv://fsong02:aeinfibeco31@cluster0.cuyqgmz.mongodb.net/?retryWrites=true&w=majority";
const dbName = 'taskbird';
const collectionName = 'tasks';

// Create a MongoClient
const client = new MongoClient(uri, { useNewUrlParser: true, useUnifiedTopology: true });

app.post('/addTask', async (req, res) => {
  const { taskName, duration, urgency } = req.body;

  try {
    // Connect to MongoDB
    await client.connect();

    // Access the database
    const db = client.db(dbName);

    // Access the collection
    const collection = db.collection(collectionName);

    // Insert the data into the collection
    const result = await collection.insertOne({
      taskName,
      duration: parseInt(duration),
      urgency: parseInt(urgency),
    });

    console.log(`Data added to MongoDB. Inserted ID: ${result.insertedId}`);

    res.status(200).json({ success: true });
  } catch (error) {
    console.error('Error adding task to MongoDB:', error);
    res.status(500).json({ success: false, error: 'Internal Server Error' });
  } finally {
    // Close the connection
    await client.close();
  }
});

app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});