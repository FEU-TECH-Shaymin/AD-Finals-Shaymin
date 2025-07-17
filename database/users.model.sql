-- USERS table
CREATE TABLE IF NOT EXISTS public.users (
    user_id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    first_name VARCHAR(225) NOT NULL,
    middle_name VARCHAR(225),
    last_name VARCHAR(225) NOT NULL,
    password VARCHAR(225) NOT NULL,
    username VARCHAR(225) NOT NULL UNIQUE,
   role VARCHAR(50) NOT NULL DEFAULT 'user'
);
