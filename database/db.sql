-- =============================================
--  STRUCTURE DE LA BASE DE DONNÉES BOLDY
-- =============================================

-- Table des rôles (Admin, Freelance...)
CREATE TABLE roles
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL
);

-- Table des utilisateurs (général : admins, freelances...)
CREATE TABLE users
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    email      VARCHAR(255) UNIQUE NOT NULL,
    password   VARCHAR(255)        NOT NULL,
    first_name VARCHAR(100)        NOT NULL,
    last_name  VARCHAR(100)        NOT NULL,
    created_at TIMESTAMP                    DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP                    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    role_id    INT                 NOT NULL DEFAULT 2,
    FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE RESTRICT
);

-- Table des freelances (infos spécifiques aux freelances)
CREATE TABLE freelancers
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    user_id         INT UNIQUE         NOT NULL,
    bio             TEXT,
    price_per_day   INT,
    location        VARCHAR(255),
    portfolio_url   VARCHAR(255),
    linkedin_url    VARCHAR(255),
    twitter_url     VARCHAR(255),
    instagram_url   VARCHAR(255),
    facebook_url    VARCHAR(255),
    profile_picture VARCHAR(255),
    cover_picture   VARCHAR(255),
    siret           VARCHAR(20) UNIQUE NOT NULL, -- Numéro de SIRET 14 chiffres ?
    is_verified     BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Table des métiers (catégories de freelances)
CREATE TABLE professions
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL
);

-- Table des relations Freelance <-> Métiers (Un freelance peut avoir plusieurs métiers)
CREATE TABLE freelancer_professions
(
    freelancer_id INT NOT NULL,
    profession_id INT NOT NULL,
    PRIMARY KEY (freelancer_id, profession_id),
    FOREIGN KEY (freelancer_id) REFERENCES freelancers (id) ON DELETE CASCADE,
    FOREIGN KEY (profession_id) REFERENCES professions (id) ON DELETE CASCADE
);

-- Table des compétences (skills)
CREATE TABLE skills
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL
);

-- Table des relations Freelance <-> Compétences (Un freelance peut avoir plusieurs skills)
CREATE TABLE freelancer_skills
(
    freelancer_id INT NOT NULL,
    skill_id      INT NOT NULL,
    PRIMARY KEY (freelancer_id, skill_id),
    FOREIGN KEY (freelancer_id) REFERENCES freelancers (id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skills (id) ON DELETE CASCADE
);

-- Table des certifications
CREATE TABLE certifications
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    freelancer_id INT          NOT NULL,
    name          VARCHAR(255) NOT NULL,
    institution   VARCHAR(255),
    year YEAR,
    FOREIGN KEY (freelancer_id) REFERENCES freelancers (id) ON DELETE CASCADE
);

-- Table des expériences professionnelles
CREATE TABLE experiences
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    freelancer_id INT          NOT NULL,
    title         VARCHAR(255) NOT NULL,
    company       VARCHAR(255) NOT NULL,
    start_date    DATE         NOT NULL,
    end_date      DATE NULL,
    description   TEXT,
    FOREIGN KEY (freelancer_id) REFERENCES freelancers (id) ON DELETE CASCADE
);

-- Table des médias (photos/vidéos des freelances)
CREATE TABLE freelancer_media
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    freelancer_id INT          NOT NULL,
    type          ENUM('image', 'video') NOT NULL,
    url           VARCHAR(255) NOT NULL,
    uploaded_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (freelancer_id) REFERENCES freelancers (id) ON DELETE CASCADE
);

-- Table des mises en avant premium
CREATE TABLE boosts
(
    id            INT PRIMARY KEY AUTO_INCREMENT,
    freelancer_id INT       NOT NULL,
    start_date    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date      TIMESTAMP NOT NULL,
    FOREIGN KEY (freelancer_id) REFERENCES freelancers (id) ON DELETE CASCADE
);

-- Table des abonnements au Business Club
CREATE TABLE subscriptions
(
    id         INT PRIMARY KEY AUTO_INCREMENT,
    user_id    INT NOT NULL,
    plan       ENUM('free', 'business_club', 'premium') NOT NULL DEFAULT 'free',
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date   TIMESTAMP NULL,
    status     ENUM('active', 'cancelled', 'expired') NOT NULL DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE blog_articles
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    title       VARCHAR(255) NOT NULL,
    content     TEXT         NOT NULL,
    cover_image VARCHAR(255),
    author_id   INT          NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE CASCADE
);

