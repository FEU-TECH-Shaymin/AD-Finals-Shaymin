-- ORDER_ITEMS table
CREATE TABLE IF NOT EXISTS public.order_items (
    item_id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    order_id UUID NOT NULL REFERENCES public.orders(order_id) ON DELETE CASCADE,
    product_id UUID NOT NULL REFERENCES public.products(product_id),
    quantity INT NOT NULL CHECK (quantity > 0)
);