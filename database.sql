-- =====================================================================
--  Laboratório de Sistemas e Serviços Web  -  e-fólio B
--  Tema: Turismo em Portugal  ("Descobrir Portugal")
--
--  Script de criação e inicialização da base de dados.
--  Executar no MySQL Workbench ligado como root (ou outro utilizador
--  com permissões para criar bases de dados e utilizadores).
--
--  ATENÇÃO: o passo 1 apaga e recria a base de dados do zero.
-- =====================================================================

-- 1) Base de dados (com o nº de estudante)
DROP DATABASE IF EXISTS trip_planner;
CREATE DATABASE trip_planner
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE trip_planner;

-- 2) Utilizador único da aplicação, com todas as permissões sobre a BD
CREATE USER IF NOT EXISTS 'lei'@'localhost' IDENTIFIED BY 'MUDAR_AQUI';
ALTER USER 'lei'@'localhost' IDENTIFIED BY 'MUDAR_AQUI';
GRANT ALL PRIVILEGES ON trip_planner.* TO 'lei'@'localhost';
FLUSH PRIVILEGES;

-- 3) Estrutura das tabelas
-- 3.1) Tipos/categorias de destino (tabela "pai")
CREATE TABLE categorias (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nome    VARCHAR(50) NOT NULL,        -- texto em português
    nome_en VARCHAR(50) NOT NULL,        -- texto em inglês
    slug    VARCHAR(50) NOT NULL UNIQUE  -- identificador técnico: cidade, costa...
) ENGINE=InnoDB;

-- 3.2) Destinos concretos (FK -> categorias)
CREATE TABLE destinos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nome         VARCHAR(100) NOT NULL,
    descricao_pt TEXT NOT NULL,
    descricao_en TEXT NOT NULL,
    imagem       VARCHAR(255),
    categoria_id INT NOT NULL,
    CONSTRAINT fk_destino_categoria
        FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB;

-- 3.3) Pedidos do formulário "Planear" (FK -> destinos)
CREATE TABLE pedidos (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    telemovel  CHAR(9) NOT NULL,
    destino_id INT,
    criado_em  DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pedido_destino
        FOREIGN KEY (destino_id) REFERENCES destinos(id)
) ENGINE=InnoDB;

-- 4) Dados iniciais
-- 4.1) Categorias
INSERT INTO categorias (nome, nome_en, slug) VALUES
    ('Cidade',   'City',   'cidade'),
    ('Costa',    'Coast',  'costa'),
    ('Interior', 'Inland', 'interior'),
    ('Natureza', 'Nature', 'natureza');

-- 4.2) Destinos (com base no conteúdo do e-fólio A)
INSERT INTO destinos (nome, descricao_pt, descricao_en, imagem, categoria_id) VALUES
    ('Lisboa',
     'Capital vibrante, cheia de bairros históricos, miradouros e elétricos tradicionais.',
     'A vibrant capital full of historic neighborhoods, viewpoints and traditional trams.',
     'img/lisbon_downtown.jpg',
     (SELECT id FROM categorias WHERE slug = 'cidade')),
    ('Porto',
     'Cidade do Douro, famosa pelas pontes, pelo centro antigo e pelo vinho do Porto.',
     'The Douro city, famous for its bridges, old center and Port wine.',
     NULL,
     (SELECT id FROM categorias WHERE slug = 'cidade')),
    ('Peneda-Gerês',
     'Trilhos, cascatas e aldeias de montanha.',
     'Trails, waterfalls and mountain villages.',
     NULL,
     (SELECT id FROM categorias WHERE slug = 'natureza')),
    ('Serra da Estrela',
     'Ponto mais alto de Portugal continental, ideal para paisagens amplas.',
     'The highest point in mainland Portugal, ideal for wide landscapes.',
     NULL,
     (SELECT id FROM categorias WHERE slug = 'natureza')),
    ('Ria Formosa',
     'Sistema lagunar com biodiversidade e ilhas-barreira.',
     'A lagoon system with biodiversity and barrier islands.',
     NULL,
     (SELECT id FROM categorias WHERE slug = 'costa'));
