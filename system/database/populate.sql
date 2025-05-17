

-- Populate sample data
SET FOREIGN_KEY_CHECKS = 0;



-- Insert sample users
-- Plaintext passwords: test:test, achuchu2:achuchu, user3:user3, bookworm:bookworm
INSERT INTO `Users` (`user_id`, `user_name`, `password`, `bio`, `acct_created`) VALUES
(1, 'test', '$2y$10$tGLaKE1bBfLHUti5raeVIOeP071Due08wPBN5i/2Z4tP7wl5GGWpu', NULL, '2025-05-01'),
(2, 'achuchu2', '$2y$10$xRRa4r6s0fx/OXLcYy95ouuRHzCX.PPuidoHJMxsiWJXMhuL0yXG6', NULL, '2025-05-02'),
(3, 'user3','$2y$10$nPcOxuEwydKy4KnE/TBqzuXZ2llYQmO3B92E08dLIfkw5ntHWQ1a.', NULL, '2025-05-03'),
(4, 'bookworm', '$2y$10$fYEHtZhh11XnEoTiyDzzveuE.EzPf5yYV0K0zy/chEC1srfXjtCd2', NULL, '2025-05-04');

-- Insert admin account
-- Plaintext password: admin:admin
INSERT INTO `Admin` (`admin_id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$DNj5uGi0qkohFeLdasP9oekmSF0IXrISEgEIipSJB4Bzm1tflJeDO');

-- Insert sample tags
INSERT INTO `Tags` (`tag_id`, `category`) VALUES
(1, 'Travel'),
(2, 'Food'),
(3, 'Technology'),
(4, 'Books'),
(5, 'Fitness'),
(6, 'Life'),
(7, 'Inspiration'),
(8, 'Humor');

INSERT INTO `Posts` (`post_id`, `user_id`, `content`, `reaction_count`, `created_At`) VALUES
(1, 1, 'Just booked my flight to Japan! Can''t wait to experience the culture and food.', 0, '2025-05-10 10:00:00'),
(2, 1, 'Learning React Native for mobile development. Any tips for a beginner?', 0, '2025-05-11 14:30:00'),
(3, 2, 'Made homemade pasta from scratch today. Nothing beats fresh pasta!', 0, '2025-05-12 09:15:00'),
(4, 2, 'Reading "Atomic Habits" - highly recommend for anyone looking to build better habits.', 0, '2025-05-12 16:45:00'),
(5, 2, 'Morning run along the beach. Nothing like starting the day with exercise and ocean views!', 0, '2025-05-13 07:00:00'),
(6, 3, 'Funny cat memes got me through my workday today. 😹', 0, '2025-05-13 12:20:00'),
(7, 3, 'Quote that inspired me today: "The only way to do great work is to love what you do."', 0, '2025-05-14 08:50:00'),
(8, 4, 'Just finished "The Midnight Library" - such a thought-provoking read about life choices.', 0, '2025-05-14 15:10:00'),
(9, 4, 'Visited the local library today and came out with 5 new books. My weekend is set!', 0, '2025-05-15 11:30:00'),
(10, 4, 'Trying out a new vegetarian recipe tonight. Hope it turns out well!', 0, '2025-05-15 18:00:00'),
(11, 4, 'Meditation and journaling every morning has completely transformed my routine.', 0, '2025-05-16 06:40:00');

-- Insert sample reactions (unchanged)
INSERT INTO `Reactions` (`post_id`, `user_id`, `reaction`) VALUES
-- Post 1 reactions (5 likes)
(1, 2, 1), (1, 3, 1), (1, 4, 1), (1, 1, 1),

-- Post 2 reactions (3 likes)
(2, 1, 1), (2, 3, 1), (2, 4, 1),

-- Post 3 reactions (8 likes)
(3, 1, 1), (3, 2, 1), (3, 3, 1), (3, 4, 1),

-- Post 4 reactions (12 likes)
(4, 1, 1), (4, 2, 1), (4, 3, 1), (4, 4, 1),

-- Post 5 reactions (7 likes)
(5, 1, 1), (5, 2, 1), (5, 3, 1), (5, 4, 1),

-- Post 6 reactions (15 likes)
(6, 1, 1), (6, 2, 1), (6, 3, 1), (6, 4, 1),

-- Post 7 reactions (9 likes)
(7, 1, 1), (7, 2, 1), (7, 3, 1), (7, 4, 1),

-- Post 8 reactions (20 likes)
(8, 1, 1), (8, 2, 1), (8, 3, 1), (8, 4, 1),

-- Post 9 reactions (14 likes)
(9, 1, 1), (9, 2, 1), (9, 3, 1), (9, 4, 1),


-- Post 10 reactions (6 likes)
(10, 1, 1), (10, 2, 1), (10, 3, 1),
(10, 4, 1),

-- Post 11 reactions (18 likes)
(11, 1, 1), (11, 2, 1), (11, 3, 1), (11, 4, 1);

-- Insert tags for each post through Post_Tags
INSERT INTO `Post_Tags` (`post_id`, `tag_id`) VALUES
-- Post 1: Japan trip (Travel, Food)
(1, 1), (1, 2),
-- Post 2: React Native (Technology)
(2, 3),
-- Post 3: Homemade pasta (Food)
(3, 2),
-- Post 4: Atomic Habits (Books, Life)
(4, 4), (4, 6),
-- Post 5: Morning run (Fitness, Travel)
(5, 5), (5, 1),
-- Post 6: Cat memes (Humor)
(6, 8),
-- Post 7: Inspirational quote (Inspiration, Life)
(7, 7), (7, 6),
-- Post 8: Midnight Library (Books, Life, Inspiration)
(8, 4), (8, 6), (8, 7),
-- Post 9: Library visit (Books, Travel)
(9, 4), (9, 1),
-- Post 10: Vegetarian recipe (Food)
(10, 2),
-- Post 11: Meditation routine (Life, Inspiration)
(11, 6), (11, 7);

-- Update reaction counts on posts
UPDATE `Posts` p
SET `reaction_count` = (
    SELECT COUNT(*) 
    FROM `Reactions` r 
    WHERE r.post_id = p.post_id
);

SET FOREIGN_KEY_CHECKS = 1;