-- Populate Departments table
INSERT INTO Departments (id, name)
VALUES 
    (1, 'Sales'),
    (2, 'Support'),
    (3, 'Marketing');

-- Populate Users table
INSERT INTO Users (id, username, password, email, firstName, lastName, type, department_id)
VALUES 
    (1, 'client1', 'password1', 'client1@example.com', 'Client', 'One', 'client', 1),
    (2, 'client2', 'password2', 'client2@example.com', 'Client', 'Two', 'client', 2),
    (3, 'agent1', 'password3', 'agent1@example.com', 'Agent', 'One', 'agent', 2),
    (4, 'agent2', 'password4', 'agent2@example.com', 'Agent', 'Two', 'agent', 3);

-- Populate Tickets table
INSERT INTO Tickets (id, user_id, agent_id, title, description, status, priority, hashtag, faq)
VALUES 
    (1, 1, 3, 'Can''t access my account', 'I''ve forgotten my password and the reset link doesn''t work', 'open', 'high', 'account', 0),
    (2, 2, 4, 'Billing issue', 'I was charged twice for my subscription', 'open', 'medium', 'billing', 0);

-- Populate Actions table
INSERT INTO Actions (id, ticket_id, user_id, action, date)
VALUES 
    (1, 1, 1, 'Created ticket', CURRENT_TIMESTAMP),
    (2, 2, 2, 'Created ticket', CURRENT_TIMESTAMP);
