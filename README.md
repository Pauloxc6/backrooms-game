# Backrooms Game

**Nota:** Este projeto foi criado como um teste e não é um jogo completo. Foi desenvolvido para fins de demonstração e experimentação com PHP e banco de dados, e pode não oferecer uma experiência de jogo real.

## Requisitos

- PHP 7.4 ou superior
- MySQL ou MariaDB
- Servidor web (por exemplo, Apache ou Nginx)
- Docker (opcional, se você usar contêineres para o banco de dados)

## Instalação

### 1. Clonar o Repositório

Clone o repositório para o seu ambiente local:

```bash
git clone <URL_DO_REPOSITORIO>
cd backrooms-game
```
### 2. Configurar o Ambiente
Banco de Dados

```sql
CREATE DATABASE IF NOT EXISTS backrooms_game;
CREATE USER IF NOT EXISTS 'backrooms'@'localhost' IDENTIFIED BY 'backrooms';
GRANT ALL PRIVILEGES ON backrooms_game.* TO 'backrooms'@'localhost';
```

Selecione o banco de bados:
```sql
USE backrooms_game;
```

Crie as tabelas:
```sql
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `info` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);
```
Boa parte feita com chat-gpt!
