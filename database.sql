CREATE DATABASE myblog_db;

USE myblog_db;

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- برای تست، دو پست آزمایشی اضافه کن:
INSERT INTO posts (title, content) VALUES
('اولین پست من', 'این متن اولین پست آزمایشی شماست. با Tailwind CSS!'),
('پست دوم', 'این هم متن دوم است برای تست کردن وبلاگ PHP شما.');
ALTER TABLE posts ADD image VARCHAR(255) AFTER title;
UPDATE posts 
SET image = 'https://source.unsplash.com/400x300/?nature,water'
WHERE id = 1;

UPDATE posts 
SET image = 'https://source.unsplash.com/400x300/?coding,php'
WHERE id = 2;
