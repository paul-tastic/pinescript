-- MYSQL Section: create a new table skill_names that will hold the possible skill_names 
-- and be referenced as a foreign key to the user_skills table. 

Steps:

    1. create new table to hold skill names:
    CREATE TABLE skill_names (
        id INT AUTO_INCREMENT PRIMARY KEY,
        skill_name VARCHAR(255) NOT NULL UNIQUE,
        created_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    );

    2. Add new column to user_skills table called skill_id (INT) that references skill_names(id)
        ALTER TABLE user_skill ADD COLUMN skill_id INT;

    3. Populate skill_names tanleble with distinct skill_names from user_skills table
        INSERT INTO skill_names (SELECT DISTINCT skill_name FROM user_skill);

    3. Populate existing records with skill_ids any skill_ids already existing in 
         UPDATE user_skill us
         JOIN skill_names sn ON us.skill_name = sn.skill_name
         SET us.skill_id = sn.id;

    4. remove skill_name column from user_skill table
        ALTER TABLE user_skill DROP COLUMN skill_name;


question 2: recreated query:
SELECT u.first_name, u.last_name, us.skill_name 
FROM users.u u
INNER JOIN user_skill us ON us.user_id = u.id;

question 3: optimize the query - I took a swing at this, got the same results as AI (ChatGPT).
select c.* 
FROM companies AS c 
JOIN users AS u USING(companyid) 
JOIN jobs AS j USING(userid) 
JOIN useraccounts AS ua USING(userid) 
WHERE j.jobid = 123;

change to: 
SELECT c.*
FROM jobs j
JOIN users u ON j.userid = u.userid
JOIN companies c ON u.companyid = c.companyid
JOIN useraccounts ua ON ua.userid = u.userid
WHERE j.jobid = 123;

- use the most selective table first: jobs. 
- change join order to align with how the data is connected.
- ensure there are indexes on the join columns (userid, companyid, jobid) for better performance.

