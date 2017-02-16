DROP Database IF EXISTS Festival_DB;
CREATE DATABASE Festival_DB;
USE Festival_DB;


DROP TABLE IF EXISTS Visitors;
CREATE TABLE Visitors (
  VisitorID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  FName VARCHAR(50) NOT NULL,
  LName VARCHAR(50) NOT NULL,
  Email VARCHAR(255),
  PhoneNumber VARCHAR(50),
  Address VARCHAR(200),
  City VARCHAR(60),
  StateProvince VARCHAR(2),
  Country VARCHAR(50),
  PostalCode VARCHAR(50),
  Comments VARCHAR(200)

);

DROP TABLE IF EXISTS Dates;
CREATE TABLE Dates (
  DateID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  FestDate Date NOT NULL

);

DROP TABLE IF EXISTS Available;
CREATE TABLE Available (
  AvailableID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Total INT NOT NULL

);

DROP TABLE IF EXISTS TicketTypes;
CREATE TABLE TicketTypes (
  TicketTypeID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(30) NOT NULL,
  Price DECIMAL(4,2) NOT NULL,
  Description VARCHAR(200),
  AvailableID INT NOT NULL

);

DROP TABLE IF EXISTS TicketAssignment;
CREATE TABLE TicketAssignment (
  TicketID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  VisitorID INT NOT NULL,
  TicketTypeID INT NOT NULL,
  DatePurchased DATE NOT NULL,
  Paid BOOLEAN,
  FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID),
  FOREIGN KEY (TicketID) REFERENCES TicketTypes(TicketTypeID)

);

DROP TABLE IF EXISTS DateAssignment;
CREATE TABLE DateAssignment (
  DateAssignmentID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  DateID INT NOT NULL,
  TicketID INT NOT NULL,
  FOREIGN KEY (DateID) REFERENCES Dates(DateID),
  FOREIGN KEY (TicketID) REFERENCES TicketAssignment(TicketID)

);

DROP TABLE IF EXISTS Users;
CREATE TABLE Users (
  UserID INT AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  AccessLevel INT NOT NULL
);

DROP TABLE IF EXISTS MerchandiseCategory;
CREATE TABLE MerchandiseCategory (
  MerchCatID INT PRIMARY KEY AUTO_INCREMENT,
  MerchCatName VARCHAR(15) NOT NULL
);

DROP TABLE IF EXISTS Merchandise;
CREATE TABLE Merchandise (
  MerchID INT PRIMARY KEY AUTO_INCREMENT,
  MerchName VARCHAR(25) NOT NULL,
  QtyMax INT NOT NULL,
  QtySold INT DEFAULT 0,
  Price VARCHAR(7) NOT NULL,
  MerchCatID INT NOT NULL,
  FOREIGN KEY (MerchCatID) REFERENCES MerchandiseCategory(MerchCatID)
);

DROP TABLE IF EXISTS PerformanceSchedule;
CREATE TABLE PerformanceSchedule (
  ScheduleID INT PRIMARY KEY AUTO_INCREMENT,
  Performer VARCHAR(25) NOT NULL,
  Stage VARCHAR(25) NOT NULL,
  PerformDate DATE NOT NULL,
  TimeFrame VARCHAR(15) NOT NULL
);

DROP TABLE IF EXISTS VendorCategory;
CREATE TABLE VendorCategory (
  VendCatID INT PRIMARY KEY AUTO_INCREMENT,
  VendCatName VARCHAR(25) NOT NULL
);

DROP TABLE IF EXISTS VendorAssignment;
CREATE TABLE VendorAssignment (
  SectionID VARCHAR(4) PRIMARY KEY,
  VendorName VARCHAR(50),
  Description VARCHAR(50),
  VisitorID INT,
  VendCatID INT,
  FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID),
  FOREIGN KEY (VendCatID) REFERENCES VendorCategory(VendCatID)
);

DROP TABLE IF EXISTS Camping;
CREATE TABLE Camping (
  CampingID VARCHAR(3) PRIMARY KEY
);

DROP TABLE IF EXISTS CampingAssignment;
CREATE TABLE CampingAssignment (
  CampAssignID INT PRIMARY KEY AUTO_INCREMENT,
  VisitorID INT NOT NULL,
  CampingID VARCHAR(3) NOT NULL,
  FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID),
  FOREIGN KEY (CampingID) REFERENCES Camping(CampingID)
);

INSERT INTO Available (AvailableID,Total)
VALUES
  (1,2400),
  (2,900),
  (3,23100),
  (4,400),
  (5,80);

INSERT INTO TicketTypes (TicketTypeID,Name,Price,Description,AvailableID)
VALUES
  (1,'WeekAdult','200.00','Full-week festival access for an adult',1),
  (2,'WeekUnderTwelve','100.00','Full-week festival access for <12 and >5',1),
  (3,'WeekUnderFive','0.00','Full-week festival access for <5',1),
  (4,'DayAdult','25.00','Day-long festival access for an adult',2),
  (5,'DayUnderTwelve','15.00','Day-long festival access for <12 and >5',2),
  (6,'DayUnderFive','0.00','Day-long festival access for <5',2),
  (7,'WeekParkingGeneral','25.00','Week-long general parking access',3),
  (8,'DayParkingGeneral','25.00','Day-long general parking access',3),
  (9,'WeekParkingVIP','25.00','Week-long VIP parking access',4),
  (10,'DayParkingVIP','10.00','Day-long VIP parking access',4),
  (11,'WeekParkingRV','25.00','Week-long RV parking access',5),
  (12,'DayParkingRV','10.00','Day-long RV parking access',5),
  (13,'DayCampingAdult','25.00','Day-long camping access for an adult',1),
  (14,'DayCampingUnderTwelve','15.00','Day-long camping access for <12 and >5',1),
  (15,'DayCampingUnderFive','0.00','Day-long camping access for <5',1);

INSERT INTO Visitors (FName,LName,PhoneNumber,Email,Address,City,StateProvince,Country,PostalCode) VALUES ("Ivana","Knight","915-9094","taciti.sociosqu.ad@cubilia.co.uk", "Ap #841-6590 Purus St.","Cincinnati","OH","USA","74260"),("Keith","Stout","1-708-497-8050","lacus@parturient.com","P.O. Box 497, 9000 Nisi Road","Springdale","AR","USA","72774"),("Georgia","Noble","1-382-628-6678","nulla.vulputate.dui@loremeumetus.net","Ap #397-6623 Sem Road","Springdale","AR","USA","72305"),("Emma","Horn","1-596-313-9666","ut.cursus@Suspendissenonleo.co.uk","P.O. Box 112, 5467 Sagittis Avenue","San Diego","CA","USA","91783"),("Octavia","Henson","1-305-920-5566","auctor.quis@hendreritDonecporttitor.co.uk","7591 Ipsum Ave","San Francisco","CA","USA","95739"),("Melyssa","Dickson","1-688-580-9503","neque.pellentesque@at.com","P.O. Box 411, 6803 Natoque Street","Worcester","MA","USA","92666"),("Virginia","Casey","1-488-436-0759","at@atnisi.ca","Ap #150-9078 Diam Ave","Pittsburgh","PA","USA","32047"),("Tatiana","Paul","1-940-972-7757","in@erosnectellus.co.uk","Ap #127-9626 Nascetur Ave","Bellevue","WA","USA","16890"),("Germane","Wilder","1-460-403-0942","amet@erat.net","Ap #193-4962 Vel Street","Cambridge","MA","USA","53519"),("Carol","Fischer","1-913-143-1312","Vivamus.nibh@nec.com","460-9997 Magna. Street","Chesapeake","VA","USA","64865");
INSERT INTO Visitors (FName,LName,PhoneNumber,Email,Address,City,StateProvince,Country,PostalCode) VALUES ("Judah","Cook","395-9297","urna.suscipit.nonummy@semelit.com","6364 Aliquam Road","Las Vegas","NV","USA","59968"),("Rashad","Hunter","1-319-327-7745","enim@nisiMauris.edu","Ap #283-3343 Nam Avenue","Bridgeport","CT","USA","75933"),("Abel","Sweeney","743-1895","placerat.orci@lectusCumsociis.net","Ap #429-3729 Risus Avenue","Olympia","WA","USA","12690"),("Blythe","Davenport","932-2493","Duis.cursus@iaculisneceleifend.ca","Ap #311-430 Dis Rd.","Shreveport","LA","USA","30715"),("Amela","Mays","914-8975","a.auctor@mieleifend.ca","600-6130 Vel Rd.","Springfield","IL","USA","29957"),("Howard","Logan","1-136-560-0589","id@molestie.com","P.O. Box 273, 944 Et Rd.","Auburn","ME","USA","84656"),("Mason","Benson","599-7938","libero.Integer@idmagna.com","Ap #414-2698 Sagittis Av.","New Orleans","LA","USA","14976"),("Adele","Becker","960-7799","ultrices.Duis@adipiscinglacusUt.net","P.O. Box 862, 9481 Fames Rd.","Tacoma","WA","USA","68800"),("Iris","Murray","1-373-784-7154","mauris@gravida.co.uk","876 Congue. Avenue","Austin","TX","USA","62652"),("Aubrey","Wilder","715-4129","sit.amet@nec.edu","6838 Phasellus Avenue","Topeka","KS","USA","96885");
INSERT INTO Visitors (FName,LName,PhoneNumber,Email,Address,City,StateProvince,Country,PostalCode) VALUES ("Jolene","Nicholson","851-0894","tellus@quam.org","Ap #688-3743 Praesent St.","Little Rock","AR","USA","71520"),("Stacey","Berry","744-8223","ornare@tellus.net","346-372 Et Rd.","Racine","WI","USA","75297"),("Cheyenne","Ortiz","432-5355","non@egestasDuisac.org","P.O. Box 989, 3910 Donec Street","West Valley City","UT","USA","92589"),("Jared","Harding","411-0428","luctus@leoelementumsem.net","8648 Lectus St.","Kenosha","WI","USA","96512"),("Nissim","Pollard","1-412-727-7668","taciti@eutellus.com","P.O. Box 606, 3682 Tincidunt. St.","Iowa City","IA","USA","76904"),("Kelsey","Gregory","1-583-900-4541","rhoncus.id.mollis@ipsumSuspendisse.org","P.O. Box 663, 463 Cras Rd.","South Bend","IN","USA","57149"),("Rosalyn","Bonner","921-5796","purus.ac@lorem.co.uk","6146 Nibh. Av.","Essex","VT","USA","45339"),("Lucy","Mcknight","392-5258","ac.sem.ut@eu.ca","P.O. Box 400, 3324 Aliquet Rd.","Worcester","MA","USA","23713"),("Hillary","Dorsey","503-0719","senectus.et.netus@dolor.ca","Ap #357-2468 Amet Street","Phoenix","AZ","USA","86132"),("Maisie","Guthrie","1-628-638-7140","Aliquam.erat@Duis.com","572-8404 Eros Ave","Milwaukee","WI","USA","82136");
INSERT INTO Visitors (FName,LName,PhoneNumber,Email,Address,City,StateProvince,Country,PostalCode) VALUES ("Zachery","Sheppard","1-172-170-1073","lacus.varius@semmollis.org","683-2990 Mattis St.","Orlando","FL","USA","77507"),("Cedric","Casey","683-0547","nec@Cras.edu","1956 Conubia St.","Bellevue","NE","USA","45152"),("Maris","Dejesus","498-3981","urna@duiFusce.net","996-9836 Magnis Street","Jonesboro","AR","USA","71965"),("Pascale","Knox","1-844-455-2260","consectetuer.rhoncus@rutrummagnaCras.com","825-6181 Nec Rd.","Louisville","KY","USA","95455"),("Megan","Schroeder","140-7705","egestas.blandit@ligulaAenean.ca","373-3142 Mi Rd.","Topeka","KS","USA","42462"),("Phoebe","Henderson","822-0618","Ut@id.co.uk","1035 Odio. Rd.","Chicago","IL","USA","37731"),("Hayfa","Carroll","593-4958","tellus@arcuSed.ca","Ap #680-7263 Massa St.","Sioux City","IA","USA","92650"),("Leilani","Arnold","1-173-843-7510","eget.magna@in.edu","915-684 Dolor Av.","Kansas City","MO","USA","45198"),("Jared","Kirk","854-8609","Duis@placeratvelitQuisque.ca","2038 Risus. Avenue","Salt Lake City","UT","USA","58905"),("Nichole","Pearson","679-0807","penatibus@Donecluctusaliquet.edu","1433 Odio. Road","Chesapeake","VA","USA","24340");

INSERT INTO merchandisecategory (MerchCatName) VALUES ("Aparrel"), ("Food/Drink"), ("Firewood"), ("Misc"), ("FirstAid"), ("Collectibles");

INSERT INTO Merchandise (MerchName, QtyMax, Price, MerchCatID) VALUES ("Reusable Cup", 1200, "$8.00", 6), ("Soda", 12000, "$1.50", 2), ("Water", 15000, "$1.00", 2), ("Chips", 5000, "$1.50", 2), ("Hamburger", 3500, "$2.50", 2), ("Hot Dog", 4000, "$2.00", 2), ("Beer", 10000, "$4.00", 2),
  ("Firewood", 10000, "$5.00", 3), ("Ice", 5000, "$1.50", 4), ("Band Aids", 200, "$4.00", 5), ("Aloe Vera", 100, "$3.00", 5), ("Sunscreen", 200, "$2.00", 5), ("Ointment", 100, "$8.00", 5), ("Tylenol", 100, "$4.00", 5), ("Tums", 100, "$4.00", 5), ("Child Small T-Shirt", 50, "$15.00", 1),
  ("Child Medium T-Shirt", 50, "$15.00", 1), ("Child Large T-Shirt", 50, "$15.00", 1), ("Child Small Hoodie", 30, "$18.00", 1), ("Child Medium Hoodie", 30, "$18.00", 1), ("Child Large Hoodie", 30, "$18.00", 1), ("Child Sweatpants", 40, "$10.00", 1), ("Adult Small T-Shirt", 500, "$25.00", 1),
  ("Adult Medium T-Shirt", 500, "$25.00", 1), ("Adult Large T-Shirt", 700, "$25.00", 1), ("Adult X-Large T-Shirt", 600, "$25.00", 1), ("Adult XXL T-Shirt", 300, "$25.00", 1), ("Adult XXXL T-Shirt", 100, "$25.00", 1), ("Adult Small Hoodie", 500, "$30.00", 1), ("Adult Medium Hoodie", 500, "$30.00", 1),
  ("Adult Large Hoodie", 500, "$30.00", 1), ("Adult X-Large Hoodie", 500, "$30.00", 1), ("Adult XXL Hoodie", 500, "$30.00", 1), ("Adult XXXL Hoodie", 500, "$30.00", 1), ("Adult Sweatpants", 100, "$12.00", 1), ("Beanie", 400, "$15.00", 1), ("Baseball Cap", 800, "$20.00", 1),
  ("Jester Hat", 300, "$30.00", 1), ("Accordion Party Hat", 1000, "$16.00", 1), ("Child Poncho", 500, "$5.00", 1), ("Adult Poncho", 500, "$10.00", 1), ("Keychain", 500, "$8.00", 6), ("Bobblehead", 500, "$12.00", 6), ("Program", 1000, "$5.00", 6), ("Hacky Sack", 500, "$2.00", 6),
  ("Accordion", 300, "$50.00", 6), ("Child's Accordion", 100, "$30.00", 6), ("Mug", 500, "$12.00", 6);

INSERT INTO Dates (FestDate) VALUES ("2017-08-07"), ("2017-08-08"), ("2017-08-09"), ("2017-08-10"), ("2017-08-11"), ("2017-08-12"), ("2017-08-13");

INSERT INTO Camping (CampingID) VALUES ("A1"), ("A2"), ("A3"), ("A4"), ("A5"), ("A6"), ("A7"), ("A8"), ("A9"), ("A10"), ("B1"), ("B2"), ("B3"), ("B4"), ("B5"), ("B6"), ("B7"), ("B8"), ("B9"), ("B10"),
  ("C1"), ("C2"), ("C3"), ("C4"), ("C5"), ("C6"), ("C7"), ("C8"), ("C9"), ("C10"), ("D1"), ("D2"), ("D3"), ("D4"), ("D5"), ("D6"), ("D7"), ("D8"), ("D9"), ("D10"), ("E1"), ("E2"), ("E3"), ("E4"), ("E5"),
  ("E6"), ("E7"), ("E8"), ("E9"), ("E10");

INSERT INTO VendorAssignment (SectionID) VALUES ("A1"), ("A2"), ("A3"), ("A4"), ("A5"), ("A6"), ("A7"), ("A8"), ("A9"), ("A10"), ("A11"), ("A12"), ("A13"), ("A14"), ("A15"), ("A16"), ("A17"), ("A18"), ("A19"), ("A20"),
  ("A21"), ("A22"), ("A23"), ("A24"), ("A25"), ("B26"), ("B27"), ("B28"), ("B29"), ("B30"), ("B31"), ("B32"), ("B33"), ("B34"), ("B35"), ("B36"), ("B37"), ("B38"), ("B39"), ("B40"), ("B41"), ("B42"), ("B43"), ("B44"), ("B45"),
  ("B46"), ("B47"), ("B48"), ("B49"), ("B50"), ("B51"), ("B52"), ("B53"), ("B54"), ("B55"), ("B56"), ("B57"), ("B58"), ("B59"), ("B60"), ("B61"), ("B62"), ("B63"), ("B64"), ("B65"), ("B66"), ("B67"), ("B68"), ("B69"), ("B70"),
  ("B71"), ("B72"), ("B73"), ("B74"), ("B75"), ("B76"), ("B77"), ("B78"), ("B79"), ("B80"), ("B81"), ("B82"), ("B83"), ("B84"), ("B85"), ("B86"), ("B87"), ("B88"), ("B89"), ("B90"), ("B91"), ("B92"), ("B93"), ("B94"), ("B95"),
  ("B96"), ("B97"), ("B98"), ("B99"), ("B100"), ("B101"), ("B102"), ("B103"), ("B104"), ("B105"), ("B106"), ("B107"), ("B108"), ("B109"), ("B110"), ("B111"), ("B112"), ("B113"), ("B114"), ("B115"), ("B116"), ("B117"), ("B118"),
  ("B119"), ("B120"), ("B121"), ("B122"), ("B123"), ("B124"), ("B125"), ("B126"), ("B127"), ("B128"), ("B129"), ("B130"), ("B131"), ("B132"), ("B133"), ("B134"), ("B135"), ("B136"), ("B137"), ("B138"), ("B139"), ("B140");

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `AccessLevel`) VALUES
  (1, 'maingate', '$2y$10$.z5ZN60WQKv4Jrb28xRkQe1qCeqHEinDI4QMDlFj2csxOQfQuZGcG', 1);