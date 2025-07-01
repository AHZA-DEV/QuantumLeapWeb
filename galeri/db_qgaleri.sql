
-- File SQL untuk create database QuantumLeap Gallery

CREATE DATABASE IF NOT EXISTS db_qgaleri;
USE db_qgaleri;

-- Tabel admin
CREATE TABLE admin (
    id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(50) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Insert default admin
INSERT INTO admin (username, password) VALUES ('admin', MD5('admin123'));

-- Tabel slider
CREATE TABLE slider (
    id int(11) NOT NULL AUTO_INCREMENT,
    judul varchar(255) NOT NULL,
    deskripsi text,
    gambar varchar(255) NOT NULL,
    status enum('aktif','nonaktif') DEFAULT 'aktif',
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Tabel galeri
CREATE TABLE galeri (
    id int(11) NOT NULL AUTO_INCREMENT,
    judul varchar(255) NOT NULL,
    deskripsi text,
    foto varchar(255) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Tabel kontak
CREATE TABLE kontak (
    id int(11) NOT NULL AUTO_INCREMENT,
    nomor_wa varchar(20) NOT NULL,
    PRIMARY KEY (id)
);

-- Insert default nomor WhatsApp
INSERT INTO kontak (nomor_wa) VALUES ('6281234567890');
