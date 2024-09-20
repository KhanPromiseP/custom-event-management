# Event Management API
Raw PHP API built to handle CRUD operations for custom event management.

**project structure**
|api
|  |config
|  |  |- Database.php
|  |models
|  |  |- Event.php
|  |events
|    |- create.php
|    |- read.php
|    |- update.php
|    |- delete.php
|-README.md
|-db.sql (for creating the 'events' table)

**Features**
Create, Read, Update, and Delete events.

**Installation**
* 1- Clone the repository.
* 2- Import the provided SQL script to set up the events table.
* 3- Update your database credentials in Database.php.

**API Endpoints**
## Create/Update Event

**Endpoints for Create & Update**
* POST /api/events/create.php (for creating) 
* PUT /api/events/update.php?id={id} (for updating)

**Common Parameters for Create & Update**
- title (required)
- date (required)
- description (optional)
- location (optional)
**Response**
* Success: { "message": "Event created/updated successfully" }
* Error: { "message": "Failed to create/update event" }

## Retrieve Event(s)
**Endpoint**
* GET /api/events/read.php

**Parameters**
* id (optional, to fetch specific event)

**Response**
* JSON array (for all events) or single event object.

## Delete Event
**Endpoint**
* DELETE /api/events/delete.php?id={id}

**Response**
* Success or failure message.