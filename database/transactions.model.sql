-- TRANSACTIONS table
CREATE TABLE IF NOT EXISTS public.transactions (
    transaction_id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL REFERENCES public.users(user_id) ON DELETE CASCADE,
    order_id UUID NOT NULL REFERENCES public.orders(order_id) ON DELETE CASCADE,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    currency VARCHAR(50) NOT NULL, -- e.g., Zombie Crystal
    amount_paid DECIMAL(10, 2) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    change DECIMAL(10, 2) GENERATED ALWAYS AS (amount_paid - total_amount) STORED,
    status VARCHAR(20) DEFAULT 'completed' -- e.g., pending, completed, failed
);
