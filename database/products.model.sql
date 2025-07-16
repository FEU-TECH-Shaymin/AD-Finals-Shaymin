-- PRODUCTS table
CREATE TABLE IF NOT EXISTS public.products (
    product_id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50), -- e.g., Weapons, Shelter, Medical
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT DEFAULT 0
);
