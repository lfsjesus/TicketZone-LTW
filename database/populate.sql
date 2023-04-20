INSERT INTO Departments (name) VALUES
    ('Sales'),
    ('Support'),
    ('Marketing');

INSERT INTO Users (username, password, email, name, type, department_id) VALUES
    ('client1', 'password1', 'client1@example.com', 'Client One', 'client', 1),
    ('client2', 'password2', 'client2@example.com', 'Client Two', 'client', 2),
    ('agent1', 'password3', 'agent1@example.com', 'Agent One', 'agent', 2),
    ('agent2', 'password4', 'agent2@example.com', 'Agent Two', 'agent', 3),
    ('admin', 'password5', 'admin@example.com', 'Administrator', 'admin', NULL);

INSERT INTO Tickets (user_id, title, description, status, priority, hashtag, faq) VALUES
    (1, 'Can''t access my account', 'I''ve forgotten my password and the reset link doesn''t work', 'open', 'high', 'account', 0),
    (2, 'Billing issue', 'I was charged twice for my subscription', 'open', 'medium', 'billing', 0);

INSERT INTO Actions (ticket_id, user_id, action) VALUES
    (1, 1, 'Created ticket'),
    (2, 2, 'Created ticket');

