-- Active: 1715162239861@@127.0.0.1@3306@peminjaman_buku

/*==============================================================*/
/* Table: ANGGOTA                                               */
/*==============================================================*/
create table ANGGOTA
(
   ID_ANGGOTA           varchar(5) not null,
   ID_PETUGAS           varchar(5) not null,
   NAMA_ANGGOTA         varchar(50) not null,
   ALAMAT               varchar(50) not null,
   NO_TELEPON           varchar(12) not null,
   EMAIL_ANGGOTA        varchar(20) not null,
   primary key (ID_ANGGOTA)

   ALTER TABLE ANGGOTA
    ADD USERNAME_ANGGOTA varchar(12) not null,
    ADD PASSWORD_ANGGOTA varchar(8) not null;

INSERT INTO ANGGOTA (ID_ANGGOTA, ID_PETUGAS, NAMA_ANGGOTA, ALAMAT, NO_TELEPON, EMAIL, USERNAME, PASSWORD)
VALUES 
('A001', 'P001', 'Faris Ilham', 'Jl. Anggrek 4', '084567890123', 'faris@example.com', 'faris_ilham', 'faris123'),
('A002', 'P001', 'Kenedy Ale', 'Jl. Tulip 5', '085678901234', 'kenedy@example.com', 'kenedy_ale', 'kenedy456');


);

/*==============================================================*/
/* Table: BUKU                                                  */
/*==============================================================*/
create table BUKU
(
   ID_BUKU              varchar(5) not null,
   ID_PETUGAS           varchar(5) not null,
   ID_PEMINJAMAN        varchar(5) not null,
   ID_PENGEMBALIAN      varchar(5) not null,
   JUDUL_BUKU           varchar(50) not null,
   PENERBIT             varchar(20) not null,
   TAHUN_TERBIT         int not null,
   JUML_HALAMAN         int not null,
   STATUS_BUKU          varchar(20),
   primary key (ID_BUKU)
);

DESC buku

ALTER TABLE BUKU DROP CONSTRAINT fk_pinjam_buku2;
ALTER TABLE BUKU DROP CONSTRAINT fk_untuk2;

ALTER TABLE BUKU
MODIFY COLUMN ID_PEMINJAMAN varchar(5) null,
MODIFY COLUMN ID_PENGEMBALIAN varchar(5) null;

ALTER TABLE BUKU
ADD COLUMN GAMBAR BLOB;

ALTER TABLE BUKU
DROP COLUMN ID_PENGEMBALIAN;

INSERT INTO BUKU (ID_BUKU, ID_PETUGAS, JUDUL_BUKU, PENERBIT, TAHUN_TERBIT, JUML_HALAMAN, STATUS_BUKU)
VALUES
('B001', 'P001', 'Harry Potter and the Sorcerer''s Stone', 'Scholastic', 1997, 320, 'Dipinjam'),
('B002', 'P001', 'To Kill a Mockingbird', 'Harper Perennial', 1960, 336, 'Dipinjam'),
('B003', 'P001', '1984', 'Signet Classic', 1949, 328, 'Dipinjam'),
('B004', 'P001', 'The Great Gatsby', 'Scribner', 1925, 180, 'Dipinjam'),
('B005', 'P001', 'Pride and Prejudice', 'Penguin Classics', 1813, 432, 'Dipinjam'),
('B006', 'P001', 'The Catcher in the Rye', 'Little, Brown and Company', 1951, 277, 'Available'),
('B007', 'P001', 'The Hobbit', 'Houghton Mifflin Harcourt', 1937, 310, 'Available'),
('B008', 'P001', 'Brave New World', 'Harper & Brothers', 1932, 311, 'Available'),
('B009', 'P001', 'Lord of the Flies', 'Faber and Faber', 1954, 224, 'Available'),
('B010', 'P001', 'The Lord of the Rings', 'George Allen & Unwin', 1954, 1216, 'Available'),
('B011', 'P001', 'The Hunger Games', 'Scholastic', 2008, 374, 'Available'),
('B012', 'P001', 'Fahrenheit 451', 'Ballantine Books', 1953, 249, 'Available'),
('B013', 'P001', 'Animal Farm', 'Secker and Warburg', 1945, 112, 'Available'),
('B014', 'P001', 'The Picture of Dorian Gray', 'Lippincott''s Monthly Magazine', 1890, 208, 'Available'),
('B015', 'P001', 'The Adventures of Huckleberry Finn', 'Charles L. Webster and Company', 1884, 366, 'Available');


-- Menambahkan ID_PEMINJAMAN ke tabel BUKU
UPDATE BUKU AS b
JOIN PEMINJAMAN AS p ON b.ID_BUKU = p.ID_BUKU
SET b.ID_PEMINJAMAN = p.ID_PEMINJAMAN;

-- Menambahkan ID_PENGEMBALIAN ke tabel BUKU
UPDATE BUKU AS b
JOIN PENGEMBALIAN AS pg ON b.ID_BUKU = pg.ID_BUKU
SET b.ID_PENGEMBALIAN = pg.ID_PENGEMBALIAN;





/*==============================================================*/
/* Table: PEMINJAMAN                                            */
/*==============================================================*/
create table PEMINJAMAN
(
   ID_PEMINJAMAN        varchar(5) not null,
   ID_PETUGAS           varchar(5) not null,
   ID_ANGGOTA           varchar(5) not null,
   ID_BUKU              varchar(5) not null,
   TGL_PEMINJAMAN       date not null,
   TGL_KEMBALI          date not null,
   primary key (ID_PEMINJAMAN)
);

INSERT INTO PEMINJAMAN (ID_PEMINJAMAN, ID_PETUGAS, ID_ANGGOTA, ID_BUKU, TGL_PEMINJAMAN, TGL_KEMBALI)
VALUES
('PM001', 'P001', 'A001', 'B001', '2024-06-01', '2024-06-15'),
('PM002', 'P001', 'A002', 'B002', '2024-06-02', '2024-06-16'),
('PM003', 'P001', 'A001', 'B003', '2024-06-03', '2024-06-17'),
('PM004', 'P001', 'A002', 'B004', '2024-06-04', '2024-06-18'),
('PM005', 'P001', 'A001', 'B005', '2024-06-05', '2024-06-19'),
('PM006', 'P001', 'A002', 'B006', '2024-06-06', '2024-06-20'),
('PM007', 'P001', 'A001', 'B007', '2024-06-07', '2024-06-21'),
('PM008', 'P001', 'A002', 'B008', '2024-06-08', '2024-06-22'),
('PM009', 'P001', 'A001', 'B009', '2024-06-09', '2024-06-23'),
('PM010', 'P001', 'A002', 'B010', '2024-06-10', '2024-06-24');



/*==============================================================*/
/* Table: PENGEMBALIAN                                          */
/*==============================================================*/
create table PENGEMBALIAN
(
   ID_PENGEMBALIAN      varchar(5) not null,
   ID_PETUGAS           varchar(5) not null,
   ID_ANGGOTA           varchar(5) not null,
   ID_BUKU              varchar(5) not null,
   TGL_PENGEMBALIAN     date not null,
   STATUS_PENGEMBALIAN  varchar(20) not null,
   primary key (ID_PENGEMBALIAN)
);

INSERT INTO PENGEMBALIAN (ID_PENGEMBALIAN, ID_PETUGAS, ID_ANGGOTA, ID_BUKU, TGL_PENGEMBALIAN, STATUS_PENGEMBALIAN)
VALUES 
('PG001', 'P001', 'A001', 'B002', '2024-01-17', 'Tepat Waktu'),
('PG002', 'P001', 'A002', 'B005', '2024-02-12', 'Terlambat'),
('PG003', 'P001', 'A001', 'B006', '2024-03-22', 'Tepat Waktu');


/*==============================================================*/
/* Table: PETUGAS                                               */
/*==============================================================*/
create table PETUGAS
(
   ID_PETUGAS           varchar(5) not null,
   NAMA_PETUGAS         varchar(50) not null,
   USERNAME_PETUGAS     varchar(12) not null,
   PASSWORD_PETUGAS     varchar(8) not null,
   EMAIL_PETUGAS        varchar(20),
   primary key (ID_PETUGAS)
);

INSERT INTO PETUGAS (ID_PETUGAS, NAMA, USERNAME, PASSWORD, EMAIL)
VALUES 
('P001', 'Petugas', 'admin', 'pass1234', 'admin@example.com')


alter table ANGGOTA add constraint FK_MENGELOLA_AGT foreign key (ID_PETUGAS)
      references PETUGAS (ID_PETUGAS) on delete restrict on update restrict;

alter table BUKU add constraint FK_MENGELOLA_BUKU foreign key (ID_PETUGAS)
      references PETUGAS (ID_PETUGAS) on delete restrict on update restrict;

alter table BUKU add constraint FK_PINJAM_BUKU2 foreign key (ID_PEMINJAMAN)
      references PEMINJAMAN (ID_PEMINJAMAN) on delete restrict on update restrict;

alter table BUKU add constraint FK_UNTUK2 foreign key (ID_PENGEMBALIAN)
      references PENGEMBALIAN (ID_PENGEMBALIAN) on delete restrict on update restrict;

alter table PEMINJAMAN add constraint FK_MEMBERIKAN foreign key (ID_PETUGAS)
      references PETUGAS (ID_PETUGAS) on delete restrict on update restrict;

alter table PEMINJAMAN add constraint FK_MENGAJUKAN foreign key (ID_ANGGOTA)
      references ANGGOTA (ID_ANGGOTA) on delete restrict on update restrict;

alter table PEMINJAMAN add constraint FK_PINJAM_BUKU foreign key (ID_BUKU)
      references BUKU (ID_BUKU) on delete restrict on update restrict;

alter table PENGEMBALIAN add constraint FK_MELAKUKAN foreign key (ID_ANGGOTA)
      references ANGGOTA (ID_ANGGOTA) on delete restrict on update restrict;

alter table PENGEMBALIAN add constraint FK_MENERIMA foreign key (ID_PETUGAS)
      references PETUGAS (ID_PETUGAS) on delete restrict on update restrict;

alter table PENGEMBALIAN add constraint FK_UNTUK foreign key (ID_BUKU)
      references BUKU (ID_BUKU) on delete restrict on update restrict;

