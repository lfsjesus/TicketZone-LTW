-- Populate Departments table
INSERT INTO Departments (id, name)
VALUES 
    (1, 'Sales'),
    (2, 'Support'),
    (3, 'Marketing');
    
-- Populate Users table
INSERT INTO Users (id, username, password, email, firstName, lastName, type, department_id)
VALUES 
    (1, 'johnsmith', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'john.smith@example.com', 'John', 'Smith', 'client', 1),
    (2, 'jane.doe', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'jane.doe@example.com', 'Jane', 'Doe', 'client', 2),
    (3, 'alexander', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'alexander@example.com', 'Alexander', 'Brown', 'agent', 2),
    (4, 'emily.johnson', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'emily.johnson@example.com', 'Emily', 'Johnson', 'admin', 3),
    (5, 'michaelwilliams', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'michael.williams@example.com', 'Michael', 'Williams', 'client', 1),
    (6, 'sarahmiller', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'sarah.miller@example.com', 'Sarah', 'Miller', 'client', 1),
    (7, 'davidwilson', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'david.wilson@example.com', 'David', 'Wilson', 'agent', 3),
    (8, 'laurajones', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'laura.jones@example.com', 'Laura', 'Jones', 'client', 2),
    (9, 'matthewthomas', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'matthew.thomas@example.com', 'Matthew', 'Thomas', 'agent', 1),
    (10, 'olivialopez', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'olivia.lopez@example.com', 'Olivia', 'Lopez', 'client', 3),
    (11, 'andrewsmith', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'andrew.smith@example.com', 'Andrew', 'Smith', 'client', 2),
    (12, 'jessicawhite', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'jessica.white@example.com', 'Jessica', 'White', 'agent', 1),
    (13, 'samueljackson', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'samuel.jackson@example.com', 'Samuel', 'Jackson', 'client', 1),
    (14, 'nataliehill', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'natalie.hill@example.com', 'Natalie', 'Hill', 'client', 2),
    (15, 'robertbrown', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'robert.brown@example.com', 'Robert', 'Brown', 'agent', 3),
    (16, 'sophiawalker', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'sophia.walker@example.com', 'Sophia', 'Walker', 'client', 1),
    (17, 'williamtaylor', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'william.taylor@example.com', 'William', 'Taylor', 'client', 3),
    (18, 'ameliasanchez', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'amelia.sanchez@example.com', 'Amelia', 'Sanchez', 'agent', 2),
    (19, 'jacobrodriguez', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'jacob.rodriguez@example.com', 'Jacob', 'Rodriguez', 'client', 2),
    (20, 'emilywright', '$2y$10$aihghdINJ6mRfJVqqiDJa.Hpu7csFdkWf9FN1OuPU2gCT.PXjHnxW', 'emily.wright@example.com', 'Emily', 'Wright', 'client', 1),
    (21, 'admin', '$2y$10$Vu4ufg.yQv2jM/ZsX1lj2eumnY38Y47KTwvEf4EjPmIHnmzaGu3bG', 'admin@gmail.com', 'Admin', '1', 'admin', 1),
    (22, 'client', '$2y$10$d7YVQ.4ndRS5F6UypBGM9.uTr3EdX7W9A7rBJKQ7dVCF6bBaYR.76', 'client@gmail.com', 'Client', '1', 'client', 1),
    (23, 'agent', '$2y$10$BzPwdqy3CbXLFU/xecTOJOTzlKghfUeUfcM9MPYi00.kYCRkQM2wm', 'agent@gmail.com', 'Agent', '1', 'agent', 1);


-- Populate Tickets table
INSERT INTO Tickets (id, user_id, agent_id, department_id, title, description, status, priority, date)
VALUES 
    (1, 1, 3, 2, 'Website Login Issue', 'I am unable to login to my account on the website.', 'assigned', 'high', CURRENT_TIMESTAMP),
    (2, 2, 7, 1, 'Product Order Delay', 'I placed an order two weeks ago and it has not arrived yet.', 'assigned', 'medium', CURRENT_TIMESTAMP),
    (3, 3, 12, 3, 'Marketing Campaign Feedback', 'I have some suggestions for improving the current marketing campaign.', 'assigned', 'low', CURRENT_TIMESTAMP),
    (4, 4, 15, 2, 'Payment Error', 'I made a payment but it was not reflected in my account.', 'assigned', 'high', CURRENT_TIMESTAMP),
    (5, 5, 12, 1, 'Product Return Request', 'I would like to return a product that I recently purchased.', 'assigned', 'medium', CURRENT_TIMESTAMP),
    (6, 6, 15, 4, 'Expense Reimbursement', 'I need to submit a reimbursement request for my recent business trip.', 'assigned', 'low', CURRENT_TIMESTAMP),
    (7, 7, 7, 3, 'Social Media Strategy', 'I have ideas for improving our social media presence and engagement.', 'assigned', 'high', CURRENT_TIMESTAMP),
    (8, 8, 18, 2, 'Website Navigation Issue', 'I am having difficulty navigating through certain pages on the website.', 'assigned', 'medium', CURRENT_TIMESTAMP),
    (9, 9, 9, 1, 'Product Compatibility Issue', 'The product I purchased is not compatible with my device.', 'assigned', 'low', CURRENT_TIMESTAMP),
    (10, 10, 7, 3, 'Advertising Campaign Inquiry', 'I would like more information about your current advertising campaigns.', 'assigned', 'high', CURRENT_TIMESTAMP),
    (11, 11, 12, 2, 'Checkout Process Error', 'There is an error during the checkout process on your website.', 'assigned', 'medium', CURRENT_TIMESTAMP),
    (12, 12, 12, 4, 'Tax Filing Assistance', 'I need help with filing my taxes for the current fiscal year.', 'assigned', 'low', CURRENT_TIMESTAMP),
    (13, 13, 15, 1, 'Product Warranty Claim', 'I want to submit a warranty claim for my faulty product.', 'assigned', 'High', CURRENT_TIMESTAMP),
    (14, 14, 18, 3, 'Social Media Advertising Proposal', 'I have a proposal for an advertising campaign on social media platforms.', 'assigned', 'medium', CURRENT_TIMESTAMP),
    (15, 15, 9, 2, 'Website Content Update', 'I noticed outdated information on your website that needs to be updated.', 'assigned', 'low', CURRENT_TIMESTAMP),
    (16, 16, 7, 1, 'Product Recommendation', 'I need recommendations for a suitable product based on my requirements.', 'assigned', 'high', CURRENT_TIMESTAMP),
    (17, 17, 3, 4, 'Expense Report Submission', 'I would like to submit my expense report for reimbursement.', 'assigned', 'medium', CURRENT_TIMESTAMP),
    (18, 18, 7, 3, 'Marketing Collateral Request', 'I need marketing collateral materials for an upcoming event.', 'assigned', 'high', CURRENT_TIMESTAMP),
    (19, 19, 12, 2, 'Account Access Issue', 'I am unable to access my account. Please assist.', 'assigned', 'medium', CURRENT_TIMESTAMP),
    (20, 20, 3, 1, 'Product Inquiry', 'I have some questions regarding your product features.', 'assigned', 'low', CURRENT_TIMESTAMP);

-- Populate TicketHashtags table
INSERT INTO TicketHashtags (id, hashtag)
VALUES 
    (1, 'password'),
    (2, 'billing'),
    (3, 'account'),
    (4, 'subscription');

-- Populate TicketTagJunction table
INSERT INTO TicketTagJunction (ticket_id, hashtag_id)
VALUES 
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (2, 4),
    (5, 1),
    (6, 2),
    (7, 3),
    (8, 4),
    (9, 1),
    (10, 2),
    (11, 3),
    (12, 4),
    (13, 1),
    (14, 2),
    (15, 3),
    (16, 4),
    (17, 1),
    (18, 2),
    (19, 3),
    (20, 4);

-- Populate Actions table
INSERT INTO Actions (id, ticket_id, user_id, action, date)
VALUES 
    (1, 1, 1, 'Created ticket', CURRENT_TIMESTAMP),
    (2, 2, 2, 'Created ticket', CURRENT_TIMESTAMP),
    (3, 3, 3, 'Created ticket', CURRENT_TIMESTAMP),
    (4, 4, 4, 'Created ticket', CURRENT_TIMESTAMP),
    (5, 5, 5, 'Created ticket', CURRENT_TIMESTAMP),
    (6, 6, 6, 'Created ticket', CURRENT_TIMESTAMP),
    (7, 7, 7, 'Created ticket', CURRENT_TIMESTAMP),
    (8, 8, 8, 'Created ticket', CURRENT_TIMESTAMP),
    (9, 9, 9, 'Created ticket', CURRENT_TIMESTAMP),
    (10, 10, 10, 'Created ticket', CURRENT_TIMESTAMP),
    (11, 11, 11, 'Created ticket', CURRENT_TIMESTAMP),
    (12, 12, 12, 'Created ticket', CURRENT_TIMESTAMP),
    (13, 13, 13, 'Created ticket', CURRENT_TIMESTAMP),
    (14, 14, 14, 'Created ticket', CURRENT_TIMESTAMP),
    (15, 15, 15, 'Created ticket', CURRENT_TIMESTAMP),
    (16, 16, 16, 'Created ticket', CURRENT_TIMESTAMP),
    (17, 17, 17, 'Created ticket', CURRENT_TIMESTAMP),
    (18, 18, 18, 'Created ticket', CURRENT_TIMESTAMP),
    (19, 19, 19, 'Created ticket', CURRENT_TIMESTAMP),
    (20, 20, 20, 'Created ticket', CURRENT_TIMESTAMP);

-- Populate Comments table
INSERT INTO Comments (id, ticket_id, user_id, comment, date)
VALUES 
    (1, 1, 3, 'Thank you for reaching out. Our team is looking into your request and will respond as soon as possible.', CURRENT_TIMESTAMP),
    (2, 2, 4, 'We appreciate your ticket. Rest assured, our team is actively working on a solution for you.', CURRENT_TIMESTAMP),
    (3, 3, 9, 'Your ticket has been received. We understand the urgency and are working to address your concerns promptly.', CURRENT_TIMESTAMP),
    (4, 4, 12, 'We value your feedback. Our team is reviewing your request and will provide you with an update shortly.', CURRENT_TIMESTAMP),
    (5, 5, 15, 'Thank you for contacting us. We understand the importance of your request and will respond promptly.', CURRENT_TIMESTAMP),
    (6, 6, 18, 'Your ticket has been logged. Our team is actively investigating the issue and will keep you updated on the progress.', CURRENT_TIMESTAMP),
    (7, 7, 3, 'We appreciate your patience. Our team is working diligently to resolve your issue and will update you soon.', CURRENT_TIMESTAMP),
    (8, 8, 12, 'Thank you for bringing this to our attention. We are investigating the matter and will provide a resolution shortly.', CURRENT_TIMESTAMP),
    (9, 9, 9, 'Your ticket is important to us. Our team is working on a solution and will reach out to you with further details.', CURRENT_TIMESTAMP),
    (10, 10, 15, 'We understand your concern. Rest assured, our team is actively addressing your issue and will provide a response soon.', CURRENT_TIMESTAMP);


INSERT INTO FAQ (question, answer) VALUES
    ('How do I submit a ticket?', 'To submit a ticket, log into your account and click on the "Create Ticket" button. Fill out the required information, including the title and description of the issue, and click "Create Ticket".'),
    ('What information should I include in my ticket?', 'When submitting a ticket, please provide as much detail as possible about the issue you are facing. Include any relevant error messages, steps to reproduce the problem, and any other information that might help our support team.'),
    ('How long does it take to receive a response to my ticket?', 'Our support team strives to respond to tickets within 24 hours of submission. However, response times may vary based on the volume of tickets received.'),
    ('Can I track the status of my ticket?', 'Yes, you can track the status of your ticket by logging into your account and visiting the "History" section. There, you will find updates and notifications regarding the progress of your ticket.'),
    ('What should I do if my ticket is marked as "Closed" but the issue persists?', 'If your ticket is marked as "Closed" but the issue you reported persists, you can reopen the ticket or submit a new ticket providing additional details.'),
    ('Can I attach files to my ticket?', 'Yes, you can attach files to your ticket to provide additional information or supporting documentation. Make sure the file size does not exceed the allowed limit.');


INSERT INTO Statuses (name) VALUES
    ('open'),
    ('assigned'),
    ('closed');