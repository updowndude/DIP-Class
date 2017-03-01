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
  DOB Date NOT NULL,
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

DROP TABLE IF EXISTS Performers;
CREATE TABLE Performers (
  PerformerID INT PRIMARY KEY AUTO_INCREMENT,
  PerformerName VARCHAR(255) NOT NULL,
  BandMembers VARCHAR(255)
);

DROP TABLE IF EXISTS Stages;
CREATE TABLE Stages (
  StageID INT PRIMARY KEY AUTO_INCREMENT,
  StageName VARCHAR(50) NOT NULL
);

DROP TABLE IF EXISTS PerformanceSchedule;
CREATE TABLE PerformanceSchedule (
  ScheduleID INT PRIMARY KEY AUTO_INCREMENT,
  PerformerID INT NOT NULL,
  StageID INT NOT NULL,
  DateID INT NOT NULL,
  StartTime Time NOT NULL,
  FOREIGN KEY (PerformerID) REFERENCES Performers(PerformerID),
  FOREIGN KEY (StageID) REFERENCES Stages(StageID),
  FOREIGN KEY (DateID) REFERENCES Dates(DateID)
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
  TicketID INT NOT NULL,
  CampingID VARCHAR(3) NOT NULL,
  FOREIGN KEY (TicketID) REFERENCES TicketAssignment(TicketID),
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

INSERT INTO Visitors (FName,LName,PhoneNumber,Email,DOB,Address,City,StateProvince,Country,PostalCode) VALUES ("Ivana","Knight","915-9094","taciti.sociosqu.ad@cubilia.co.uk","1960-09-04","Ap #841-6590 Purus St.","Cincinnati","OH","USA","74260"),("Keith","Stout","1-708-497-8050","lacus@parturient.com","1943-07-05","P.O. Box 497, 9000 Nisi Road","Springdale","AR","USA","72774"),("Georgia","Noble","1-382-628-6678","nulla.vulputate.dui@loremeumetus.net","1923-12-27","Ap #397-6623 Sem Road","Springdale","AR","USA","72305"),("Emma","Horn","1-596-313-9666","ut.cursus@Suspendissenonleo.co.uk","1944-02-13","P.O. Box 112, 5467 Sagittis Avenue","San Diego","CA","USA","91783"),("Octavia","Henson","1-305-920-5566","auctor.quis@hendreritDonecporttitor.co.uk","1994-06-07","7591 Ipsum Ave","San Francisco","CA","USA","95739"),("Melyssa","Dickson","1-688-580-9503","neque.pellentesque@at.com","1950-05-07","P.O. Box 411, 6803 Natoque Street","Worcester","MA","USA","92666"),("Virginia","Casey","1-488-436-0759","at@atnisi.ca","1960-12-22","Ap #150-9078 Diam Ave","Pittsburgh","PA","USA","32047"),("Tatiana","Paul","1-940-972-7757","in@erosnectellus.co.uk","1974-02-05","Ap #127-9626 Nascetur Ave","Bellevue","WA","USA","16890"),("Germane","Wilder","1-460-403-0942","amet@erat.net","1918-12-04","Ap #193-4962 Vel Street","Cambridge","MA","USA","53519"),("Carol","Fischer","1-913-143-1312","Vivamus.nibh@nec.com","1988-06-12","460-9997 Magna. Street","Chesapeake","VA","USA","64865");
INSERT INTO Visitors (FName,LName,PhoneNumber,Email,DOB,Address,City,StateProvince,Country,PostalCode) VALUES ("Judah","Cook","395-9297","urna.suscipit.nonummy@semelit.com","1915-10-31","6364 Aliquam Road","Las Vegas","NV","USA","59968"),("Rashad","Hunter","1-319-327-7745","enim@nisiMauris.edu","1990-06-28","Ap #283-3343 Nam Avenue","Bridgeport","CT","USA","75933"),("Abel","Sweeney","743-1895","placerat.orci@lectusCumsociis.net","1969-05-24","Ap #429-3729 Risus Avenue","Olympia","WA","USA","12690"),("Blythe","Davenport","932-2493","Duis.cursus@iaculisneceleifend.ca","1928-11-09","Ap #311-430 Dis Rd.","Shreveport","LA","USA","30715"),("Amela","Mays","914-8975","a.auctor@mieleifend.ca","1907-05-15","600-6130 Vel Rd.","Springfield","IL","USA","29957"),("Howard","Logan","1-136-560-0589","id@molestie.com","1942-10-04","P.O. Box 273, 944 Et Rd.","Auburn","ME","USA","84656"),("Mason","Benson","599-7938","libero.Integer@idmagna.com","1992-05-06","Ap #414-2698 Sagittis Av.","New Orleans","LA","USA","14976"),("Adele","Becker","960-7799","ultrices.Duis@adipiscinglacusUt.net","1907-12-15","P.O. Box 862, 9481 Fames Rd.","Tacoma","WA","USA","68800"),("Iris","Murray","1-373-784-7154","mauris@gravida.co.uk","1933-10-08","876 Congue. Avenue","Austin","TX","USA","62652"),("Aubrey","Wilder","715-4129","sit.amet@nec.edu","1985-01-29","6838 Phasellus Avenue","Topeka","KS","USA","96885");
INSERT INTO Visitors (FName,LName,PhoneNumber,Email,DOB,Address,City,StateProvince,Country,PostalCode) VALUES ("Jolene","Nicholson","851-0894","tellus@quam.org","1995-08-04","Ap #688-3743 Praesent St.","Little Rock","AR","USA","71520"),("Stacey","Berry","744-8223","ornare@tellus.net","2000-12-20","346-372 Et Rd.","Racine","WI","USA","75297"),("Cheyenne","Ortiz","432-5355","non@egestasDuisac.org","1956-10-14","P.O. Box 989, 3910 Donec Street","West Valley City","UT","USA","92589"),("Jared","Harding","411-0428","luctus@leoelementumsem.net","1968-04-16","8648 Lectus St.","Kenosha","WI","USA","96512"),("Nissim","Pollard","1-412-727-7668","taciti@eutellus.com","1997-04-26","P.O. Box 606, 3682 Tincidunt. St.","Iowa City","IA","USA","76904"),("Kelsey","Gregory","1-583-900-4541","rhoncus.id.mollis@ipsumSuspendisse.org","1928-10-01","P.O. Box 663, 463 Cras Rd.","South Bend","IN","USA","57149"),("Rosalyn","Bonner","921-5796","purus.ac@lorem.co.uk","1909-11-26","6146 Nibh. Av.","Essex","VT","USA","45339"),("Lucy","Mcknight","392-5258","ac.sem.ut@eu.ca","1923-01-18","P.O. Box 400, 3324 Aliquet Rd.","Worcester","MA","USA","23713"),("Hillary","Dorsey","503-0719","senectus.et.netus@dolor.ca","1905-06-21","Ap #357-2468 Amet Street","Phoenix","AZ","USA","86132"),("Maisie","Guthrie","1-628-638-7140","Aliquam.erat@Duis.com","1977-07-24","572-8404 Eros Ave","Milwaukee","WI","USA","82136");
INSERT INTO Visitors (FName,LName,PhoneNumber,Email,DOB,Address,City,StateProvince,Country,PostalCode) VALUES ("Zachery","Sheppard","1-172-170-1073","lacus.varius@semmollis.org","1982-08-03","683-2990 Mattis St.","Orlando","FL","USA","77507"),("Cedric","Casey","683-0547","nec@Cras.edu","1921-10-03","1956 Conubia St.","Bellevue","NE","USA","45152"),("Maris","Dejesus","498-3981","urna@duiFusce.net","1967-05-06","996-9836 Magnis Street","Jonesboro","AR","USA","71965"),("Pascale","Knox","1-844-455-2260","consectetuer.rhoncus@rutrummagnaCras.com","1992-07-31","825-6181 Nec Rd.","Louisville","KY","USA","95455"),("Megan","Schroeder","140-7705","egestas.blandit@ligulaAenean.ca","1968-02-01","373-3142 Mi Rd.","Topeka","KS","USA","42462"),("Phoebe","Henderson","822-0618","Ut@id.co.uk","1912-03-24","1035 Odio. Rd.","Chicago","IL","USA","37731"),("Hayfa","Carroll","593-4958","tellus@arcuSed.ca","1976-04-15","Ap #680-7263 Massa St.","Sioux City","IA","USA","92650"),("Leilani","Arnold","1-173-843-7510","eget.magna@in.edu","1905-07-10","915-684 Dolor Av.","Kansas City","MO","USA","45198"),("Jared","Kirk","854-8609","Duis@placeratvelitQuisque.ca","1944-08-30","2038 Risus. Avenue","Salt Lake City","UT","USA","58905"),("Nichole","Pearson","679-0807","penatibus@Donecluctusaliquet.edu","1930-08-25","1433 Odio. Road","Chesapeake","VA","USA","24340");

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

INSERT INTO VendorAssignment (SectionID) VALUES
  ("B53"), ("B54"), ("B55"), ("B56"), ("B57"), ("B58"), ("B59"), ("B60"), ("B61"), ("B62"), ("B63"), ("B64"), ("B65"), ("B66"), ("B67"), ("B68"), ("B69"), ("B70"),
  ("B71"), ("B72"), ("B73"), ("B74"), ("B75"), ("B76"), ("B77"), ("B78"), ("B79"), ("B80"), ("B81"), ("B82"), ("B83"), ("B84"), ("B85"), ("B86"), ("B87"), ("B88"), ("B89"), ("B90"), ("B91"), ("B92"), ("B93"), ("B94"), ("B95"),
  ("B96"), ("B97"), ("B98"), ("B99"), ("B100"), ("B101"), ("B102"), ("B103"), ("B104"), ("B105"), ("B106"), ("B107"), ("B108"), ("B109"), ("B110"), ("B111"), ("B112"), ("B113"), ("B114"), ("B115"), ("B116"), ("B117"), ("B118"),
  ("B119"), ("B120"), ("B121"), ("B122"), ("B123"), ("B124"), ("B125"), ("B126"), ("B127"), ("B128"), ("B129"), ("B130"), ("B131"), ("B132"), ("B133"), ("B134"), ("B135"), ("B136"), ("B137"), ("B138"), ("B139"), ("B140");

INSERT INTO VendorCategory (VendCatName) VALUES ("Aparrel"), ("Instruments"), ("Books"), ("Repair"), ("Body Art"), ("Entertainment Media"), ("Misc");

INSERT INTO VendorAssignment (SectionID, VendorName, Description, VisitorID, VendCatID) VALUES ("A1", "Accordion City Mega Mall", "Instrument store", 11, 2), ("A2", "Accordion City Mega Mall", "Instrument store", 11, 2), ("A3", "Accordion City Mega Mall", "Instrument store", 11, 2), ("A4", "Accordion City Mega Mall", "Instrument store", 11, 2), ("A5", "Accordion City Mega Mall", "Instrument store", 11, 2),
  ("A6", "Kate's Kustom Keyboards", "Modifications & repair", 12, 4),
  ("A7", "Malleus Malificarum Supplies", "Antiquarian books", 3, 3),
  ("A8", "Hammered Steel and Leather", "Custom iron-work fittings & clothes", 20, 1), ("A9", "Hammered Steel and Leather", "Custom iron-work fittings & clothes", 20, 1), ("A10", "Hammered Steel and Leather", "Custom iron-work fittings & clothes", 20, 1),
  ("A11", "Concertina Nation Super Store", "Instrument store", 2, 2), ("A12", "Concertina Nation Super Store", "Instrument store", 2, 2), ("A13", "Concertina Nation Super Store", "Instrument store", 2, 2), ("A14", "Concertina Nation Super Store", "Instrument store", 2, 2), ("A15", "Concertina Nation Super Store", "Instrument store", 2, 2),
  ("A16", "Nothing But Bagpipes!", "Instrument store", 27, 2), ("A17", "Nothing But Bagpipes!", "Instrument store", 27, 2), ("A18", "Nothing But Bagpipes!", "Instrument store", 27, 2),
  ("A19", "Digeridoo-wop Sound Stylists", "Instrument store", 29, 2), ("A20", "Digeridoo-wop Sound Stylists", "Instrument store", 29, 2), ("A21", "Digeridoo-wop Sound Stylists", "Instrument store", 29, 2),
  ("A22", "The Vinyl Antiquarian", "Old & current vinyl & tapes", 16, 6), ("A23", "The Vinyl Antiquarian", "Old & current vinyl & tapes", 16, 6),
  ("B26", "Patch the Bellows Fixer", "Instrument repair", 22, 4), ("B27", "Patch the Bellows Fixer", "Instrument repair", 22, 4), ("B28", "Patch the Bellows Fixer", "Instrument repair", 22, 4),
  ("B29", "Jim's DX Instrument Repair", "Instrument repair", 35, 4), ("B30", "Jim's DX Instrument Repair", "Instrument repair", 35, 4), ("B31", "Jim's DX Instrument Repair", "Instrument repair", 35, 4), ("B32", "Jim's DX Instrument Repair", "Instrument repair", 35, 4),
  ("B33", "Tattoos That Stay to Go", "Tattoos & piercings", 14, 5), ("B34", "Tattoos That Stay to Go", "Tattoos & piercings", 14, 5), ("B35", "Tattoos That Stay to Go", "Tattoos & piercings", 14, 5),
  ("A24", "Bob the CD Guy", "Old & current CDs & DVDs", 4, 6), ("A25", "Bob the CD Guy", "Old & current CDs & DVDs", 4, 6),
  ("B36", "Instruments You Never Knew Existed", "World music instruments", 38, 2), ("B37", "Instruments You Never Knew Existed", "World music instruments", 38, 2), ("B38", "Instruments You Never Knew Existed", "World music instruments", 38, 2),
  ("B39", "Jack and the Shruti Box", "World music instruments", 34, 2),
  ("B40", "The Future Isn't What it Used to Be", "Prepper supplies & literature", 18, 7), ("B41", "The Future Isn't What it Used to Be", "Prepper supplies & literature", 18, 7), ("B42", "The Future Isn't What it Used to Be", "Prepper supplies & literature", 18, 7),
  ("B43", "Little Gem Electronics Division", "Music, electronics, & repair", 31, 7), ("B44", "Little Gem Electronics Division", "Music, electronics, & repair", 31, 7), ("B45", "Little Gem Electronics Division", "Music, electronics, & repair", 31, 7),
  ("B46", "Books and More", "Books & music", 6, 7), ("B47", "Books and More", "Books & music", 6, 7),
  ("B48", "The Ink Spot", "Tattoos & piercings", 32, 5), ("B49", "The Ink Spot", "Tattoos & piercings", 32, 5),
  ("B50", "Footwear for the End of the World", "Custom footwear", 1, 1), ("B51", "Footwear for the End of the World", "Custom footwear", 1, 1), ("B52", "Footwear for the End of the World", "Custom footwear", 1, 1);

INSERT INTO Stages (StageName) VALUES ("Concertina Corner"), ("Rockin' Out the Polkas"), ("Main Squeeze");

INSERT INTO Performers (PerformerName, BandMembers) VALUES ("Goat Cheese Pizza", "Chastity Shields, Violet Graham, Jerry Valez"), ("Squeeze Play", "Amir Welch, Nicholas Cortez, Mackenzie Clemons"), ("Bellows Benders", "Yoshi Horne, Xenos Murray, Hunter Langley"), ("Accordion to Hoyle", "Martin Hoyle, James Hoyle, Zena Higgens"), ("Have Another Beer", "Martin Fowler, Stone Hubert, Hoyt Baker"), ("Lynyrd Skynyrd Accordion Tribute", "Wyoming Poole, Austin Holland, Holmes Moody"), ("Led Bellows", "Adele Patel, Carson Stout, Cherokee Sosa"), ("Squeezebox Serenaders", "Kiona Pruitt, Cynthia Velasquez, Aretha Gay, Tana Palmer"), ("Sona Revisited", "Caleb Bass, Catherine Trujillo, Erasmus Merritt"), ("Funkadelions", "Ralph Parish, Justin Stanley, Tiger Rhodes, Nathaniel Molina"),
  ("Tennessee Ernie Toyota", "Ernie Donaldson"), ("Basket of Deplorables", "Malachi Rhodes, Dominic Hudson, Angelica Kerr, Iko Donaldson, Jeannette Bradley"), ("The Lorem Ipsums", "Oscar Griffith, Jared Calahan, Chadwick Morrow, Jaden Knapp"), ("Captain Keyboard and the Squeezettes", "Carlos Marx, Jada Carney, Cheyenne Arnold, Erica Hancock, Dierdre Willis"), ("Skydiving Elvis and the Accordion Impersonators", "Elvis Reed, Odysseus Benson, Yao Lambert"), ("Darth Polka", "Aristotle Allison"), ("Concertina Warriors", "Gail Castaneda, Tanner Cameron, Farrah Taylor"), ("Elderly Mutant Ninja Toads", "Darryl Waters, Lane Jiminez, Lars McKee, Denton Richards"), ("Barney Fife and the Drum Corps", "Barney Fife, Casim Lamb, Chad Arnold, Kieron Datsun, Brennon Brewer"), ("Chaos and the Death Star Polka", "Wayne House, Robert Bird, Kirby Flynn, Selma Petty"),
  ("Not Your Grandpa's Polka Band", "Phillip Sutton, Clayton Baird, Christos Dixon, Miles Selenez"), ("Ford Prefect Trio", "Baxter Warner, Beau Woodard, Drake Stevens"), ("All the Diodes on My Left Side", "Whoopi Rogers, Denton Jenson, Tad Berry"), ("404-Band Not Found", "Vaughan Camacho, Gage Rollins, Melvin Harring"), ("Your Mileage May Vary", "Emily Simon, Angela Doyle, Kathleen McClain"), ("Bob's Your Uncle", "Bob Hatfield, Bobby Meyers, Robert Bryan, Robby Greene"), ("Four Horsemen of the the Apocalypse Jug Band", "Darren Burnett, Teagan Rollins, Davis Bowing, Maisie Frederick"), ("But Wait! There's More!", "Lucian Fernandez, Kaden Lynch, Idola Stephenson, Alexander Landry, Demetrius Rosallus"), ("Thor's Crescent Wrench", "Gunnar Lidstrom, Nickolas Holmstrom, Siri Cronwall"), ("Polka Fever", "Beau Hunt, Michael Norman, Keith Pate"), ("The Usual Gang of Idiots", "Eugene George, Oliver Cochran, Isaiah Kemp, Channing Dillard, Leroy Fuller"),
  ("Death and Destruction in 3/4 Time", "Lucius York, Molly Montgomery, Savannah Port, Midge Garza"), ("Bob Wills Meets Gene Simmons", "Bob Simmons, Gene Wills"), ("The Apolkalypse is Coming", "Joshua McCoy, Benjamin Gills, Jack Fletcher, Lenore Norton"), ("TCP and the Three-Way Handshake", "Terry Postlethwait, Mallory Morrow, Richard Pruitt, Fuller Sullivan"), ("Moonrise at Litha", "Ivy Joyce, Lana Fischer, Azalea Mills"), ("Contents May Have Settled", "Declan Griffin, Rowana Douglas, Mannix Riddle"), ("Bacon Lettuce and Potato", "Neil Pork, Ayana Cabbage, Roy O'Brian"), ("LMJ X11 and Back", "Griffith Sears, Rebecca McKee, Yvette Golden, Joy James"), ("The Middle Management Trio", "Seth Harrington, Amir Goode, Signe Dyer"), ("And You Thought It Couldn't Get Worse", "Martin Rollins, Brittney Waller, Raphael de la Cruz"),
  ("Major Spammeister and the Robocallers", "Lev Knoxx, Cameron Chase, Cameron Golden, Caleb Murphy, Teagan Cash");

INSERT INTO PerformanceSchedule (PerformerID, StageID, DateID, StartTime) VALUES (17, 1, 1, "12:00:00"), (8, 1, 1, "14:00:00"), (23, 1, 1, "16:00:00"), (28, 1, 1, "18:00:00"), (15, 1, 1, "20:00:00"), (33, 1, 1, "22:00:00");

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `AccessLevel`) VALUES
  (1, 'maingate', '$2y$10$.z5ZN60WQKv4Jrb28xRkQe1qCeqHEinDI4QMDlFj2csxOQfQuZGcG', 1);