-- Create the commodities table
CREATE TABLE commodities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

-- Create the prices table
CREATE TABLE prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commodity_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    season INT NOT NULL,
    FOREIGN KEY (commodity_id) REFERENCES commodities(id) ON DELETE CASCADE
);

-- Insert initial data
INSERT INTO commodities (name) VALUES ('Oats');
INSERT INTO prices (commodity_id, price, season) VALUES (1, 1200.00, 1);
