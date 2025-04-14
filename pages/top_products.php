
<?php


// Fetch top 10 best-selling products from both tables
$query = "
    SELECT 
        id, 
        product_name, 
        product_image, 
        product_price, 
        product_type, 
        category_id, 
        COALESCE(avg_rating, 0) AS rating, 
        COALESCE(total_reviews, 0) AS reviews_count, 
        total_sold
    FROM (
        -- Fetch top-selling products from cosmet_products
        SELECT 
            c.id, 
            c.product_name, 
            c.product_image, 
            c.product_price, 
            'cosmetics' AS product_type, 
            NULL AS category_id,  -- No category_id for cosmetics
            SUM(oi.quantity) AS total_sold,
            AVG(pr.rating) AS avg_rating, 
            COUNT(pr.id) AS total_reviews
        FROM 
            cosmet_products c
        JOIN 
            order_items oi ON c.id = oi.product_id
        LEFT JOIN 
            product_reviews pr ON c.id = pr.product_id
        GROUP BY 
            c.id

        UNION ALL

        -- Fetch top-selling products from jewelry_products
        SELECT 
            j.id, 
            j.product_name, 
            j.product_image, 
            j.product_price, 
            'jewelry' AS product_type, 
            j.category_id,  -- Ensure category_id is included
            SUM(oi.quantity) AS total_sold,
            AVG(pr.rating) AS avg_rating, 
            COUNT(pr.id) AS total_reviews
        FROM 
            jewelry_products j
        JOIN 
            order_items oi ON j.id = oi.product_id
        LEFT JOIN 
            product_reviews pr ON j.id = pr.product_id
        GROUP BY 
            j.id, j.category_id  -- Group by category_id as well
    ) AS combined_products
    ORDER BY 
        total_sold DESC
    LIMIT 4;
";


$result = $conn->query($query);
?>
