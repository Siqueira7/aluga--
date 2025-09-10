-- Criação do banco de dados, tabelas e dados de demonstração para o sistema Aluga++
CREATE DATABASE IF NOT EXISTS alugapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE alugapp;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    token_jwt VARCHAR(255),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    tempo_maximo INT NOT NULL, -- em horas
    disponivel BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS locacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    veiculo_id INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    tempo INT NOT NULL, -- em horas
    data_locacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (veiculo_id) REFERENCES veiculos(id)
);

-- Veículos de demonstração
INSERT INTO veiculos (modelo, tipo, valor, tempo_maximo, disponivel) VALUES
('Honda CG 160', 'Moto', 80.00, 24, TRUE),
('Fiat Uno', 'Carro', 120.00, 48, TRUE),
('Yamaha Fazer', 'Moto', 90.00, 24, TRUE),
('Volkswagen Gol', 'Carro', 130.00, 48, TRUE);
