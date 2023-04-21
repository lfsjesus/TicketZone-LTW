DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Tickets;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Departments;
DROP TABLE IF EXISTS Actions;
DROP TABLE IF EXISTS TicketHashtags;

CREATE TABLE Users (
    id INT PRIMARY KEY,
    username VARCHAR NOT NULL UNIQUE,
    password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    firstName VARCHAR NOT NULL,
    lastName VARCHAR NOT NULL,
    type VARCHAR NOT NULL,
    department_id INT REFERENCES departments(id)
);

CREATE TABLE Tickets (
    id INT PRIMARY KEY,
    user_id INT NOT NULL REFERENCES users(id),
    agent_id INT NOT NULL REFERENCES users(id),
    title VARCHAR NOT NULL,
    description VARCHAR NOT NULL,
    status VARCHAR NOT NULL,
    priority VARCHAR NOT NULL,
    date TIMESTAMP NOT NULL,
    faq BOOLEAN NOT NULL
);

CREATE TABLE TicketHashtags (
    id INT PRIMARY KEY,
    ticket_id INT NOT NULL REFERENCES tickets(id),
    hashtag VARCHAR NOT NULL
);

CREATE TABLE Comments (
    id INT PRIMARY KEY,
    ticket_id INT NOT NULL REFERENCES tickets(id),
    user_id INT NOT NULL REFERENCES users(id),
    comment VARCHAR NOT NULL,
    date TIMESTAMP NOT NULL
);

CREATE TABLE Departments (
    id INT PRIMARY KEY,
    name VARCHAR NOT NULL
);

CREATE TABLE Actions (
    id INT PRIMARY KEY,
    ticket_id INT NOT NULL REFERENCES tickets(id),
    user_id INT NOT NULL REFERENCES users(id),
    action VARCHAR NOT NULL,
    date TIMESTAMP NOT NULL
);

