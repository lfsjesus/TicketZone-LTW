DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Tickets;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Departments;
DROP TABLE IF EXISTS Actions;
DROP TABLE IF EXISTS TicketHashtags;
DROP TABLE IF EXISTS TicketTagJunction;
DROP TABLE IF EXISTS Files;

CREATE TABLE Users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR NOT NULL UNIQUE,
    password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    firstName VARCHAR NOT NULL,
    lastName VARCHAR NOT NULL,
    type VARCHAR NOT NULL,
    department_id INT REFERENCES Departments(id)
);

CREATE TABLE Tickets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INT NOT NULL REFERENCES Users(id),
    agent_id INT REFERENCES Users(id),
    department_id INT REFERENCES Departments(id),
    title VARCHAR NOT NULL,
    description VARCHAR NOT NULL,
    status VARCHAR NOT NULL,
    priority VARCHAR,
    date TIMESTAMP NOT NULL,
    faq BOOLEAN NOT NULL
);

CREATE TABLE TicketHashtags (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    hashtag VARCHAR NOT NULL
);

CREATE TABLE TicketTagJunction (
    ticket_id INT NOT NULL REFERENCES Tickets(id),
    hashtag_id INT NOT NULL REFERENCES TicketHashtags(id),
    PRIMARY KEY (ticket_id, hashtag_id)
);

CREATE TABLE Comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ticket_id INT NOT NULL REFERENCES Tickets(id) ON DELETE CASCADE,
    user_id INT NOT NULL REFERENCES Users(id),
    comment VARCHAR NOT NULL,
    date TIMESTAMP NOT NULL
);

CREATE TABLE Departments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL
);

CREATE TABLE Actions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ticket_id INT NOT NULL REFERENCES Tickets(id),
    user_id INT NOT NULL REFERENCES Users(id),
    action VARCHAR NOT NULL,
    date TIMESTAMP NOT NULL
);

CREATE TABLE Files (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ticket_id INT REFERENCES Tickets(id),
    comment_id INT REFERENCES Comments(id), 
    file_data BLOB NOT NULL,
    CHECK (ticket_id IS NULL OR comment_id IS NULL)
);

