DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS actions;

CREATE TABLE users (
    id INT PRIMARY KEY,
    username VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    name VARCHAR NOT NULL,
    type VARCHAR NOT NULL,
    department_id INT REFERENCES departments(id)
);

CREATE TABLE tickets (
    id INT PRIMARY KEY,
    user_id INT NOT NULL REFERENCES users(id),
    agent_id INT NOT NULL REFERENCES users(id),
    title VARCHAR NOT NULL,
    description VARCHAR NOT NULL,
    status VARCHAR NOT NULL,
    priority VARCHAR NOT NULL,
    hashtag VARCHAR NOT NULL,
    faq BOOLEAN NOT NULL
);

CREATE TABLE comments (
    id INT PRIMARY KEY,
    ticket_id INT NOT NULL REFERENCES tickets(id),
    user_id INT NOT NULL REFERENCES users(id),
    comment VARCHAR NOT NULL,
    date TIMESTAMP NOT NULL
);

CREATE TABLE departments (
    id INT PRIMARY KEY,
    name VARCHAR NOT NULL
);

CREATE TABLE actions (
    id INT PRIMARY KEY,
    ticket_id INT NOT NULL REFERENCES tickets(id),
    user_id INT NOT NULL REFERENCES users(id),
    action VARCHAR NOT NULL,
    date TIMESTAMP NOT NULL
);




