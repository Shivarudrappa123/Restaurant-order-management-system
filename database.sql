CREATE DATABASE foodiehub;
USE foodiehub;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE menu_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image_url VARCHAR(255),
    is_customizable BOOLEAN DEFAULT FALSE
);

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL,
    customizations TEXT,
    item_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);

INSERT INTO menu_items (name, description, price, category, image_url, is_customizable) VALUES 
('Vegetable Pulao', 'Fragrant basmati rice cooked with mixed vegetables and aromatic spices', 99.00, 'main-course', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0', 1),
('Special Thali', 'Complete meal with 2 rotis, dal, rice, 2 sabji, raita, and papad', 209.00, 'main-course', 'https://images.unsplash.com/photo-1645177628172-a94c1f96e6db', 1),
('Mix Vegetable Sabji', 'Fresh mixed vegetables cooked with Indian spices', 109.00, 'main-course', 'https://images.unsplash.com/photo-1628294895950-9805252327bc', 1),
('Samosa', 'Crispy pastry filled with spiced potatoes and peas (2 pieces)', 40.00, 'starters', 'https://images.unsplash.com/photo-1601050690597-df0568f70950', 1),
('Gulab Jamun', 'Sweet milk dumplings soaked in sugar syrup (2 pieces)', 60.00, 'desserts', 'https://images.unsplash.com/photo-1582716401301-b2407dc7563d', 1);


INSERT INTO users (name, email, phone, password, is_admin) 
VALUES ('Admin', 'admin@foodiehub.com', '1234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE);