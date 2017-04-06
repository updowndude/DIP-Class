DROP Database IF EXISTS dips2017_Festival_DB;
CREATE DATABASE dips2017_Festival_DB;
USE dips2017_Festival_DB;

DROP TABLE IF EXISTS Quantity;
CREATE TABLE Quantity (
  QuantityID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  QuantityMax INT NOT NULL,
  QuantityAvailable INT NOT NULL
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
  Price DECIMAL(4,2) NOT NULL,
  Image VARCHAR(45) NOT NULL,
  Description VARCHAR(255),
  MerchCatID INT NOT NULL,
  QuantityID INT NOT NULL,
  FOREIGN KEY (MerchCatID) REFERENCES MerchandiseCategory(MerchCatID),
  FOREIGN KEY (QuantityID) REFERENCES Quantity(QuantityID)
);


DROP TABLE IF EXISTS Users;
CREATE TABLE Users (
  UserID INT AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,
  AccessLevel INT NOT NULL
);

DROP TABLE IF EXISTS Visitors;
CREATE TABLE Visitors (
  VisitorID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  UserID INT NOT NULL,
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
  Comments VARCHAR(200),
  FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

DROP TABLE IF EXISTS TicketAssignment;
CREATE TABLE TicketAssignment (
  TicketID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  VisitorID INT NOT NULL,
  MerchID INT NOT NULL,
  DatePurchased DATE NOT NULL,
  Paid BOOLEAN,
  CheckedIN BOOLEAN,
  LicensePlate VARCHAR(10),
  LicenseIssuedIn VARCHAR(20),
  FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID),
  FOREIGN KEY (MerchID) REFERENCES Merchandise(MerchID)
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
  StartTime TIMESTAMP NOT NULL,
  FOREIGN KEY (PerformerID) REFERENCES Performers(PerformerID),
  FOREIGN KEY (StageID) REFERENCES Stages(StageID)
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
  CampingID CHAR(3) PRIMARY KEY
);

DROP TABLE IF EXISTS Announcements;
CREATE TABLE Announcements (
  AnnounceID INT PRIMARY KEY AUTO_INCREMENT,
  AnnouncementTitle VARCHAR(255) NOT NULL,
  AnnouncementText VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS Orders;
CREATE TABLE Orders (
  OrderID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  VisitorID INT NOT NULL,
  DatePurchased Date NOT NULL,
  Paid BOOLEAN NOT NULL,
  FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID)
);

DROP TABLE IF EXISTS TicketAssignment;
CREATE TABLE TicketAssignment (
  TicketID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  VisitorID INT NOT NULL,
  MerchID INT NOT NULL,
  DatePurchased DATE NOT NULL,
  Paid BOOLEAN,
  CheckedIN BOOLEAN,
  LicensePlate VARCHAR(10),
  LicenseIssuedIn VARCHAR(20),
  QuantityID INT,
  FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID),
  FOREIGN KEY (QuantityID) REFERENCES Quantity(QuantityID),
  FOREIGN KEY (MerchID) REFERENCES Merchandise(MerchID)
);

DROP TABLE IF EXISTS LineItems;
CREATE TABLE LineItems (
  LineItemID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  OrderID INT NOT NULL,
  MerchID INT NOT NULL,
  Quantity INT NOT NULL,
  Discount DECIMAL(2,2) NOT NULL,
  FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
  FOREIGN KEY (MerchID) REFERENCES Merchandise(MerchID)

);

DROP TABLE IF EXISTS CampingAssignment;
CREATE TABLE CampingAssignment (
  CampAssignID INT PRIMARY KEY AUTO_INCREMENT,
  TicketID INT NOT NULL,
  CampingID CHAR(3) NOT NULL,
  FOREIGN KEY (TicketID) REFERENCES TicketAssignment(TicketID),
  FOREIGN KEY (CampingID) REFERENCES Camping(CampingID)
);


INSERT INTO Quantity (QuantityID, QuantityMax, QuantityAvailable)
VALUES
  (1,2400,2400),
  (2,900,900),
  (3,23100,23100),
  (4,400,400),
  (5,80,80),
  (6, 1200, 1200),
  (7, 15000, 15000),
  (8, 3500, 3500),
  (9, 4000, 4000),
  (10, 5000, 5000),
  (11, 10000, 10000),
  (12, 100, 100),
  (13, 200, 200),
  (14, 300, 300),
  (15, 400, 400),
  (16, 500, 500),
  (17, 600, 600),
  (18, 700, 700),
  (19, 800, 800),
  (20, 50, 50),
  (21, 40, 40),
  (22, 30, 30),
  (23, 1000, 1000),
  (24, 12000, 12000),
  (25, 5000, 5000),
  (26, 200, 200),
  (27, 100, 100),
  (28, 100, 100),
  (29, 100, 100),
  (30, 50, 50),
  (31, 50, 50),
  (32, 30, 30),
  (33, 30, 30),
  (34, 500, 500),
  (35, 500, 500),
  (36, 500, 500),
  (37, 500, 500),
  (38, 500, 500),
  (39, 500, 500),
  (40, 500, 500),
  (41, 500, 500),
  (42, 500, 500),
  (43, 500, 500),
  (44, 500, 500),
  (45, 500, 500),
  (46, 500, 500),
  (47, 100, 100),
  (48, 500, 500),
  (49, 300, 300),
  (50, 300, 500),
  (51, 100, 100),
  (52, 1000, 1000),
  (53, 10000, 10000),
  (54,900,900),
  (55,900,900),
  (56,900,900),
  (57,900,900),
  (58,900,900),
  (59,900,900),
  (60,900,900),
  (61,900,900),
  (62,900,900),
  (63,900,900),
  (64,900,900),
  (65,900,900),
  (66,900,900);

INSERT INTO MerchandiseCategory (MerchCatID, MerchCatName) VALUES (1, "Aparrel"), (2, "Food/Drink"), (3, "Firewood"), (4, "Misc"), (5, "FirstAid"), (6, "Collectibles"),
  (7, "DayAdmissionTickets"), (8, "WeekAdmissionTickets"), (9, "DayParkingTickets"), (10, "WeekParkingTickets"), (11, "DayCampingTickets");


INSERT INTO Merchandise (MerchID, MerchName, QuantityID, Price, MerchCatID, Description) VALUES (1, "Reusable Cup", 6, 8.00, 6, null), (2, "Soda", 24, 1.20, 2, null), (3, "Water", 7, 1.00, 2, null), (4, "Chips", 25, 1.20, 2, null), (5, "Hamburger", 8, 2.20, 2, null), (6, "Hot Dog", 9, 2.00, 2, null), (7, "Beer", 11, 4.00, 2, null),
  (8, "Firewood", 53, 5.00, 3, null), (9, "Ice", 10, 1.20, 4, null), (10, "Band Aids", 13, 4.00, 5, null), (11, "Aloe Vera", 12, 3.00, 5, null), (12, "Sunscreen", 26, 2.00, 5, null), (13, "Ointment", 27, 8.00, 5, null), (14, "Tylenol", 28, 4.00, 5, null), (15, "Tums", 29, 4.00, 5, null), (16, "Child Small T-Shirt", 20, 15.00, 1, null),
  (17, "Child Medium T-Shirt", 30, 15.00, 1, null), (18, "Child Large T-Shirt", 31, 15.00, 1, null), (19, "Child Small Hoodie", 22, 18.00, 1, null), (20, "Child Medium Hoodie", 32, 18.00, 1, null), (21, "Child Large Hoodie", 33, 18.00, 1, null), (22, "Child Sweatpants", 21, 10.00, 1, null), (23, "Adult Small T-Shirt", 16, 25.00, 1, null),
  (24, "Adult Medium T-Shirt", 34, 25.00, 1, null), (25, "Adult Large T-Shirt", 18, 25.00, 1, null), (26, "Adult X-Large T-Shirt", 17, 25.00, 1, null), (27, "Adult XXL T-Shirt", 14, 25.00, 1, null), (28, "Adult XXXL T-Shirt", 47, 25.00, 1, null), (29, "Adult Small Hoodie", 35, 22.00, 1, null), (30, "Adult Medium Hoodie", 36, 22.00, 1, null),
  (31, "Adult Large Hoodie", 37, 22.00, 1, null), (32, "Adult X-Large Hoodie", 38, 22.00, 1, null), (33, "Adult XXL Hoodie", 39, 22.00, 1, null), (34, "Adult XXXL Hoodie", 40, 22.00, 1, null), (35, "Adult Sweatpants", 48, 12.00, 1, null), (36, "Beanie", 15, 15.00, 1, null), (37, "Baseball Cap", 19, 20.00, 1, null),
  (38, "Jester Hat", 49, 22.00, 1, null), (39, "Accordion Party Hat", 23, 16.00, 1, null), (40, "Child Poncho", 41, 5.00, 1, null), (41, "Adult Poncho", 42, 10.00, 1, null), (42, "Keychain", 43, 8.00, 6, null), (43, "Bobblehead", 44, 12.00, 6, null), (44, "Program", 52, 5.00, 6, null), (45, "Hacky Sack", 45, 2.00, 6, null),
  (46, "Accordion", 50, 20.00, 6, null), (47, "Child's Accordion", 51, 22.00, 6, null), (48, "Mug", 46, 12.00, 6, null),

  (49, "Ticket Adult_Week", 1, 200.00, 8, 'Full-week festival access for an adult'),
  (55, "Ticket Adult_Mo", 2, 25.00, 7, 'Monday festival access for an adult'),
  (56, "Ticket Adult_Tu", 54, 25.00, 7, 'Tuesday festival access for an adult'),
  (57, "Ticket Adult_We", 55, 25.00, 7, 'Wednesday festival access for an adult'),
  (58, "Ticket Adult_Th", 56, 25.00, 7, 'Thursday festival access for an adult'),
  (59, "Ticket Adult_Fr", 57, 25.00, 7, 'Friday festival access for an adult'),
  (60, "Ticket Adult_Sa", 58, 25.00, 7, 'Saturday festival access for an adult'),
  (61, "Ticket Adult_Su", 59, 25.00, 7, 'Sunday festival access for an adult'),
  (50, "Ticket UnderTwelve_Week", 1, 100.00, 8, 'Full-week festival access for children under 12'),
  (62, "Ticket UnderTwelve_Mo", 2, 15.00, 7, 'Monday festival access for children under 12'),
  (63, "Ticket UnderTwelve_Tu", 54, 15.00, 7, 'Tuesday festival access for children under 12'),
  (64, "Ticket UnderTwelve_We", 55, 15.00, 7, 'Wednesday festival access for children under 12'),
  (65, "Ticket UnderTwelve_Th", 56, 15.00, 7, 'Thursday festival access for children under 12'),
  (66, "Ticket UnderTwelve_Fr", 57, 15.00, 7, 'Friday festival access for children under 12'),
  (67, "Ticket UnderTwelve_Sa", 58, 15.00, 7, 'Saturday festival access for children under 12'),
  (68, "Ticket UnderTwelve_Su", 59, 15.00, 7, 'Sunday festival access for children under 12'),
  (51, "Ticket UnderFive_Week", 1, 0.00, 8, 'Full-week festival access for children under 5'),
  (69, "Ticket UnderFive_Mo", 2, 0.00, 7, 'Monday festival access for children under 5'),
  (70, "Ticket UnderFive_Tu", 54, 0.00, 7, 'Tuesday festival access for children under 5'),
  (71, "Ticket UnderFive_We", 55, 0.00, 7, 'Wednesday festival access for children under 5'),
  (72, "Ticket UnderFive_Th", 56, 0.00, 7, 'Thursday festival access for children under 5'),
  (73, "Ticket UnderFive_Fr", 57, 0.00, 7, 'Friday festival access for children under 5'),
  (74, "Ticket UnderFive_Sa", 58, 0.00, 7, 'Saturday festival access for children under 5'),
  (75, "Ticket UnderFive_Su", 59, 0.00, 7, 'Sunday festival access for children under 5'),

  (52, 'WeekParkingGeneral', 3, 25.00, 10,'Week-long general parking access'),
  (76, 'DayParkingGeneral_Mo', 3, 5.00, 9, 'Monday general parking access'),
  (77, 'DayParkingGeneral_Tu', 3, 5.00, 9, 'Tuesday general parking access'),
  (78, 'DayParkingGeneral_We', 3, 5.00, 9, 'Wednesday general parking access'),
  (79, 'DayParkingGeneral_Th', 3, 5.00, 9, 'Thursday general parking access'),
  (80, 'DayParkingGeneral_Fr', 3, 5.00, 9, 'Friday general parking access'),
  (81, 'DayParkingGeneral_Sa', 3, 5.00, 9, 'Saturday general parking access'),
  (82, 'DayParkingGeneral_Su', 3, 5.00, 9, 'Sunday general parking access'),

  (53, 'WeekParkingVIP', 4, 50.00, 10, 'Week-long VIP parking access'),
  (83, 'DayParkingVIP_Mo', 4, 10.00, 9, 'Monday VIP parking access'),
  (84, 'DayParkingVIP_Tu', 4, 10.00, 9, 'Tuesday VIP parking access'),
  (85, 'DayParkingVIP_We', 4, 10.00, 9, 'Wednesday VIP parking access'),
  (86, 'DayParkingVIP_Th', 4, 10.00, 9, 'Thursday VIP parking access'),
  (87, 'DayParkingVIP_Fr', 4, 10.00, 9, 'Friday VIP parking access'),
  (88, 'DayParkingVIP_Sa', 4, 10.00, 9, 'Saturday VIP parking access'),
  (89, 'DayParkingVIP_Su', 4, 10.00, 9, 'Sunday VIP parking access'),

  (54, 'WeekParkingRV', 5, 100.00, 10, 'Week-long RV parking access'),
  (90, 'DayParkingRV_Mo', 5, 20.00, 9, 'Monday RV parking access'),
  (91, 'DayParkingRV_Tu', 5, 20.00, 9, 'Tuesday RV parking access'),
  (92, 'DayParkingRV_We', 5, 20.00, 9, 'Wednesday RV parking access'),
  (93, 'DayParkingRV_Th', 5, 20.00, 9, 'Thursday RV parking access'),
  (94, 'DayParkingRV_Fr', 5, 20.00, 9, 'Friday RV parking access'),
  (95, 'DayParkingRV_Sa', 5, 20.00, 9, 'Saturday RV parking access'),
  (96, 'DayParkingRV_Su', 5, 20.00, 9, 'Sunday RV parking access'),

  (97, 'DayCampingAdult_Mo', 60, 25.00, 11, 'Monday camping access for an adult'),
  (98, 'DayCampingAdult_Tu', 61, 25.00, 11, 'Tuesday camping access for an adult'),
  (99, 'DayCampingAdult_We', 62, 25.00, 11, 'Wednesday camping access for an adult'),
  (100, 'DayCampingAdult_Th', 63, 25.00, 11, 'Thursday camping access for an adult'),
  (101, 'DayCampingAdult_Fr', 64, 25.00, 11, 'Friday camping access for an adult'),
  (102, 'DayCampingAdult_Sa', 65, 25.00, 11, 'Saturday camping access for an adult'),
  (103, 'DayCampingAdult_Su', 66, 25.00, 11, 'Sunday camping access for an adult'),

  (104, 'DayCampingUnderTwelve_Mo', 60, 15.00, 11, 'Monday camping access for children under 12'),
  (105, 'DayCampingUnderTwelve_Tu', 61, 15.00, 11, 'Tuesday camping access for children under 12'),
  (106, 'DayCampingUnderTwelve_We', 62, 15.00, 11, 'Wednesday camping access for children under 12'),
  (107, 'DayCampingUnderTwelve_Th', 63, 15.00, 11, 'Thursday camping access for children under 12'),
  (108, 'DayCampingUnderTwelve_Fr', 64, 15.00, 11, 'Friday camping access for children under 12'),
  (109, 'DayCampingUnderTwelve_Sa', 65, 15.00, 11, 'Saturday camping access for children under 12'),
  (110,'DayCampingUnderTwelve_Su', 66, 15.00, 11, 'Sunday camping access for children under 12'),

  (111, 'DayCampingUnderFive_Mo', 60, 0.00, 11, 'Monday camping access for children under 5'),
  (112, 'DayCampingUnderFive_Tu', 61, 0.00, 11, 'Tuesday camping access for children under 5'),
  (113, 'DayCampingUnderFive_We', 62, 0.00, 11, 'Wednesday camping access for children under 5'),
  (114, 'DayCampingUnderFive_Th', 63, 0.00, 11, 'Thursday camping access for children under 5'),
  (115, 'DayCampingUnderFive_Fr', 64, 0.00, 11, 'Friday camping access for children under 5'),
  (116, 'DayCampingUnderFive_Sa', 65, 0.00, 11, 'Saturday camping access for children under 5'),
  (117, 'DayCampingUnderFive_Su', 66, 0.00, 11, 'Sunday camping access for children under 5');

/*
	need to adjust the MerchID (the third number in the insert) and also adjust for the change to how we're doing the daily tickets now i believe
*/

INSERT INTO Users (Username, Password, AccessLevel) VALUES ("thebigcheese", "$2y$10$Lle9WvZM/rOrGF3IeltFN.O5EC5TqIvptb9HR7pDFe8EtyD0T7fRa", 5), -- Festival Chief
  ("maingateadmin", "$2y$10$hpfuFl/vAy/yBxDUXxpiZO3SKDNXAPtFiK06PB/uy8eDexm.xg8PG", 4), -- main gate admin
  ("infocenteradmin", "$2y$10$t7STijXiAboszVmxNKT.De0YVtUVmZjuGcHlSqSPuX6lFXKHSPUHm", 4), /* info center admin*/
  ("websiteadmin", "$2y$10$TOp1BC8Dyrpeb7dkb.pyveV1sJw2yO/MPJSFkAYVsa4PDysISDUxi", 4), /* Web Site admin*/
  ("maingate", "$2y$10$jsyTg2xtarh36OzbtfFshuzIUl7fWs/nUKOTUg88JByrBmGoHQQGq", 2), /* main gate user*/
  ("infocenter", "$2y$10$ktPOfB.0W.YppBWtMqabhelZJwCzYxZPSSwdhXcCHACf2FF1R4wjy", 3), /* info center user admin*/
  ("Abebouno984","$2y$10$UsGG.gWoIG/RrngDTN9EAODQG9V/SwsDBT9U7rxrW6Lnvzu0TepYa",1),
  ("Balaonethmi6jpz","$2y$10$Hm3woCCAOfjXJAEw93VANe1b8VFB9IfDeabEHDExx4gaPf14PXcxK",1),
  ("ChronCy264","$2y$10$sKXOpYVL9KEGYOE7oDNHy.WLYDV2fGeOjF27qkmXwWD3.cxWLjaje",1),
  ("Hiwayment5v","$2y$10$l2ovpfjzqZJOCu9iedeya.4KSrfhk73z43K2wzb7KGlhDbqD64jqC",1),
  ("Knightfire18","$2y$10$Ja/XH/irCSJr7eeRjzJRZ.NLkpkcl1BQ3lojBmFJlvmcdxysXbqH.",1),
  ("Nsmilepart5Bb","$2y$10$PspEzQF27yUjLevlKG0iXuoRI8yYuYm5B6gcIyUXp14JKLrrmgCPe",1),
  ("Airadorta463","$2y$10$hMuVTSdGTaxJZMlmEJ0tSO8xcbSOTWGJP7C4XJO0SjZTtU6KC8vVW",1),
  ("Buckebu6yo","$2y$10$2b9AYwRRBfSHo5RyhcvuCu0Thu.rM3Pen4JX5YWCPOI/3snMb.bCi",1),
  ("Dingteho4aJz","$2y$10$OZ2xs6zYFYwmyeAQ22jAKuX9vrerzv3kf7pJixVlVK7xDUhT2FngW",1),
  ("Ignorce66Q4","$2y$10$DbPsdtAzp/W7HHk0eFIsIuNXAwJXl/9JTRDb/p2bTRYH/G/TzGqnm",1),
  ("LogiroliX1y","$2y$10$WQ6imIuBr6z83bbvaH3juO/K5aHljrjJ796meQSr/UrXHUC3XpNqO",1),
  ("Peakerento55G","$2y$10$ouilbegoxApTc937S5mwOuSVMq3LdJlgkjIeMOUXLUhegdYsKyaY6",1),
  ("AllopholeM2F","$2y$10$Ba8q/wYA6vTeDa/aLraJ.eE3ef3h4RJY66XZMR1CWvJn0/EAzTmAS",1),
  ("Cewiress5KO","$2y$10$YOnmw3zDaX8cKIMm5uURn.GoT66tb4vWphQdOddoJqXPiRocqJQue",1),
  ("Elkalati538","$2y$10$OGBG.0LWCoFrs7SCfbdv0uR3jC2tpz0k5w5rv03qZKbNIEsdjZklq",1),
  ("IncentrZ9o","$2y$10$MR.3LIOKRYYjDkXOMtcICuWWpHHDA3zwD2T5A0chisZw3AI1N/KXe",1),
  ("Mainligen83GO","$2y$10$FEDT76vgTd0Mgbu0adPUfuS9ZpO3o3lYYFAKvsKABoDKS1FbBoGPu",1),
  ("Peetsaway7DqU","$2y$10$ffsh9bdWSJMaX5EMhBGxLeBkBfdZi1Wui0rOYM9cQwrijoWlMFj7C",1),
  ("Amylerwor82Mi","$2y$10$Uc971FLifz.HxgVCoPxq0e1x6sFntcqfyjhtzh2m72xnnQeuMy/vW",1),
  ("Chiaridesk3Hq","$2y$10$rHRm063ZyW737NYo1vE8KOZHtfX.s9hikkQvtc6l3BRuFyJ0cmECu",1),
  ("Fixerbesi6qZ","$2y$10$GXa4Qbw25mEPG899o7LyY.xLI6SHpclpeYy9GwwtNHXk3K3E6jy8G",1),
  ("InformerbyQ4","$2y$10$uGuo//8NEuALBgWBUxVRT.1JdW/D60Z6wNgQO8aaeUReBbygru2FS",1),
  ("Marketek0o","$2y$10$3.ja1SeM1GFBL2lYyhHqFeQtywcD0L/EjTM0tfBTwOz3XD5r65HAm",1),
  ("Polypsa91D","$2y$10$jqfJ/YbQZ0EPZIxQdm7nkOEWhkNhqWCVJzkaSSordx8cDDo0licX.",1),
  ("BagoDevDiscover2I","$2y$10$tsCTzlt6NiqRxJ.MwfUTA.U3JDZlpauS73qIG6IkHu.ypiKIEJIXS",1),
  ("Chrissie0cF","$2y$10$AP6TtWxxeyS60ksBugrUtO5QrKc1b2D4/LoLHzl1A4c4TzjCWxmKG",1),
  ("Hearson8084","$2y$10$PzT5QXfcmqtSrniIiMtyzOOj6wcFIwGO2FctvJMt5XVxkOeXygI3q",1),
  ("Italfotch8K","$2y$10$FjrF07V57Fz3MDTFVQpLLePucxQAaae0hWNSKs4Pv4F4OK.bCJwFO",1),
  ("Mentone97o","$2y$10$k1VqI1OiHvwLzKGI32ldFuEJS7c5UEiKCuGH68XfZ4KJS.MxGig8G",1),
  ("Pothobs33g","$2y$10$4w.MBSnZ0IkIt7v7/gqeCuJzO3pJ2sEVzr2fIbzNxKFjLO9i1nf/W",1),
  ("Aguelasz0b","$2y$10$Ekw2EoDj.1UhBK8bRfyjU.TMyuewF/gCXujUgVfaDioZRygnbmCHK",1),
  ("Consfokk9z","$2y$10$IrV6FgoQz5mivT.0lVT4.egn0KiZ6LnA5oZjE5nj0ULY74koWRwJS",1),
  ("Dudetiger06","$2y$10$TxPJWHsyhImbVZltuNBlEu6h2cs/.8u/WVjirU6vgVWi0MEkVGVbC",1),
  ("xLegolasx1337","$2y$10$rmgMSKH8Q2k/u7Vyx1jrguOKstv2O55FB491Ttuw5GkqUseTAjID2",1),
  ("DOOMsPartan69","$2y$10$k4GAKZSlNCRo0b3UjmRSA.TYFE/CBaWehbkhghnSlNw.K9GhVx19O",1),
  ("Phatcat64","$2y$10$rKlx4KDxQppWQdjObwBbsO2RkO2CFzZFnNUhbDxpgHFRcmCPAqeA.",1),
  ("Trumpdumper2","$2y$10$fgWBOkwKw4lUZ8kdKjQA6uxihrqniGQ00Tn7UHILdwxf5HjRZAqPq",1),
  ("CoolGuyXXX69","$2y$10$epppD6fLZIiscqPVa/E8m.8WeZZhIVP9tHEvMxu4Ak2VK7cFMKOUi",1),
  ("Kidjo6o0","$2y$10$fmIQTtMdoy6y9wlPkkZiMuMJejbZV20CFWgaxjvMTnCKpST8l1HCu",1),
  ("Lovelywort20U","$2y$10$19lTUay3i2hUKGOL80EkbuyZGV3OA8JSJyqBoM0UROyHaU5PzXUle",1),
  ("FourTman9f","$2y$10$IOYf1HAOJZmHu34OrbFrfe3KxjyNVq4ABP1J0oT.NFXgkymZIYRJC",1);

INSERT INTO Visitors (UserID,FName,LName,PhoneNumber,Email,DOB,Address,City,StateProvince,Country,PostalCode) VALUES (1,"Ivana","Knight","915-9094","taciti.sociosqu.ad@cubilia.co.uk","1960-09-04","Ap #841-6590 Purus St.","Cincinnati","OH","USA","74260"),(2,"Keith","Stout","1-708-497-8050","lacus@parturient.com","1943-07-05","P.O. Box 497, 9000 Nisi Road","Springdale","AR","USA","72774"),(3,"Georgia","Noble","1-382-628-6678","nulla.vulputate.dui@loremeumetus.net","1923-12-27","Ap #397-6623 Sem Road","Springdale","AR","USA","72305"),(4,"Emma","Horn","1-596-313-9666","ut.cursus@Suspendissenonleo.co.uk","1944-02-13","P.O. Box 112, 5467 Sagittis Avenue","San Diego","CA","USA","91783"),(5,"Octavia","Henson","1-305-920-5566","auctor.quis@hendreritDonecporttitor.co.uk","1994-06-07","7591 Ipsum Ave","San Francisco","CA","USA","95739"),(6,"Melyssa","Dickson","1-688-580-9503","neque.pellentesque@at.com","1950-05-07","P.O. Box 411, 6803 Natoque Street","Worcester","MA","USA","92666"),(7,"Virginia","Casey","1-488-436-0759","at@atnisi.ca","1960-12-22","Ap #150-9078 Diam Ave","Pittsburgh","PA","USA","32047"),(8,"Tatiana","Paul","1-940-972-7757","in@erosnectellus.co.uk","1974-02-05","Ap #127-9626 Nascetur Ave","Bellevue","WA","USA","16890"),(9,"Germane","Wilder","1-460-403-0942","amet@erat.net","1918-12-04","Ap #193-4962 Vel Street","Cambridge","MA","USA","53519"),(10,"Carol","Fischer","1-913-143-1312","Vivamus.nibh@nec.com","1988-06-12","460-9997 Magna. Street","Chesapeake","VA","USA","64865");
INSERT INTO Visitors (UserID,FName,LName,PhoneNumber,Email,DOB,Address,City,StateProvince,Country,PostalCode) VALUES (11,"Judah","Cook","395-9297","urna.suscipit.nonummy@semelit.com","1915-10-31","6364 Aliquam Road","Las Vegas","NV","USA","59968"),(12,"Rashad","Hunter","1-319-327-7745","enim@nisiMauris.edu","1990-06-28","Ap #283-3343 Nam Avenue","Bridgeport","CT","USA","75933"),(13,"Abel","Sweeney","743-1895","placerat.orci@lectusCumsociis.net","1969-05-24","Ap #429-3729 Risus Avenue","Olympia","WA","USA","12690"),(14,"Blythe","Davenport","932-2493","Duis.cursus@iaculisneceleifend.ca","1928-11-09","Ap #311-430 Dis Rd.","Shreveport","LA","USA","30715"),(15,"Amela","Mays","914-8975","a.auctor@mieleifend.ca","1907-05-15","600-6130 Vel Rd.","Springfield","IL","USA","29957"),(16,"Howard","Logan","1-136-560-0589","id@molestie.com","1942-10-04","P.O. Box 273, 944 Et Rd.","Auburn","ME","USA","84656"),(17,"Mason","Benson","599-7938","libero.Integer@idmagna.com","1992-05-06","Ap #414-2698 Sagittis Av.","New Orleans","LA","USA","14976"),(18,"Adele","Becker","960-7799","ultrices.Duis@adipiscinglacusUt.net","1907-12-15","P.O. Box 862, 9481 Fames Rd.","Tacoma","WA","USA","68800"),(19,"Iris","Murray","1-373-784-7154","mauris@gravida.co.uk","1933-10-08","876 Congue. Avenue","Austin","TX","USA","62652"),(20,"Aubrey","Wilder","715-4129","sit.amet@nec.edu","1985-01-29","6838 Phasellus Avenue","Topeka","KS","USA","96885");
INSERT INTO Visitors (UserID,FName,LName,PhoneNumber,Email,DOB,Address,City,StateProvince,Country,PostalCode) VALUES (21,"Jolene","Nicholson","851-0894","tellus@quam.org","1995-08-04","Ap #688-3743 Praesent St.","Little Rock","AR","USA","71520"),(22,"Stacey","Berry","744-8223","ornare@tellus.net","2000-12-20","346-372 Et Rd.","Racine","WI","USA","75297"),(23,"Cheyenne","Ortiz","432-5355","non@egestasDuisac.org","1956-10-14","P.O. Box 989, 3910 Donec Street","West Valley City","UT","USA","92589"),(24,"Jared","Harding","411-0428","luctus@leoelementumsem.net","1968-04-16","8648 Lectus St.","Kenosha","WI","USA","96512"),(25,"Nissim","Pollard","1-412-727-7668","taciti@eutellus.com","1997-04-26","P.O. Box 606, 3682 Tincidunt. St.","Iowa City","IA","USA","76904"),(26,"Kelsey","Gregory","1-583-900-4541","rhoncus.id.mollis@ipsumSuspendisse.org","1928-10-01","P.O. Box 663, 463 Cras Rd.","South Bend","IN","USA","57149"),(27,"Rosalyn","Bonner","921-5796","purus.ac@lorem.co.uk","1909-11-26","6146 Nibh. Av.","Essex","VT","USA","45339"),(28,"Lucy","Mcknight","392-5258","ac.sem.ut@eu.ca","1923-01-18","P.O. Box 400, 3324 Aliquet Rd.","Worcester","MA","USA","23713"),(29,"Hillary","Dorsey","503-0719","senectus.et.netus@dolor.ca","1905-06-21","Ap #357-2468 Amet Street","Phoenix","AZ","USA","86132"),(30,"Maisie","Guthrie","1-628-638-7140","Aliquam.erat@Duis.com","1977-07-24","572-8404 Eros Ave","Milwaukee","WI","USA","82136");
INSERT INTO Visitors (UserID,FName,LName,PhoneNumber,Email,DOB,Address,City,StateProvince,Country,PostalCode) VALUES (31,"Zachery","Sheppard","1-172-170-1073","lacus.varius@semmollis.org","1982-08-03","683-2990 Mattis St.","Orlando","FL","USA","77507"),(32,"Cedric","Casey","683-0547","nec@Cras.edu","1921-10-03","1956 Conubia St.","Bellevue","NE","USA","45152"),(33,"Maris","Dejesus","498-3981","urna@duiFusce.net","1967-05-06","996-9836 Magnis Street","Jonesboro","AR","USA","71965"),(34,"Pascale","Knox","1-844-455-2260","consectetuer.rhoncus@rutrummagnaCras.com","1992-07-31","825-6181 Nec Rd.","Louisville","KY","USA","95455"),(35,"Megan","Schroeder","140-7705","egestas.blandit@ligulaAenean.ca","1968-02-01","373-3142 Mi Rd.","Topeka","KS","USA","42462"),(36,"Phoebe","Henderson","822-0618","Ut@id.co.uk","1912-03-24","1035 Odio. Rd.","Chicago","IL","USA","37731"),(37,"Hayfa","Carroll","593-4958","tellus@arcuSed.ca","1976-04-15","Ap #680-7263 Massa St.","Sioux City","IA","USA","92650"),(38,"Leilani","Arnold","1-173-843-7510","eget.magna@in.edu","1905-07-10","915-684 Dolor Av.","Kansas City","MO","USA","45198"),(39,"Jared","Kirk","854-8609","Duis@placeratvelitQuisque.ca","1944-08-30","2038 Risus. Avenue","Salt Lake City","UT","USA","58905"),(40,"Nichole","Pearson","679-0807","penatibus@Donecluctusaliquet.edu","1930-08-25","1433 Odio. Road","Chesapeake","VA","USA","24340");

INSERT INTO Camping (CampingID) VALUES ("A01"), ("A02"), ("A03"), ("A04"), ("A05"), ("A06"), ("A07"), ("A08"), ("A09"), ("A10"), ("B01"), ("B02"), ("B03"), ("B04"), ("B05"), ("B06"), ("B07"), ("B08"), ("B09"), ("B10"),
  ("C01"), ("C02"), ("C03"), ("C04"), ("C05"), ("C06"), ("C07"), ("C08"), ("C09"), ("C10"), ("D01"), ("D02"), ("D03"), ("D04"), ("D05"), ("D06"), ("D07"), ("D08"), ("D09"), ("D10"), ("E01"), ("E02"), ("E03"), ("E04"), ("E05"),
  ("E06"), ("E07"), ("E08"), ("E09"), ("E10");

INSERT INTO VendorAssignment (SectionID) VALUES
  ("B120"), ("B121"), ("B122"), ("B123"), ("B124"), ("B125"), ("B126"), ("B127"), ("B128"), ("B129"), ("B130"), ("B131"), ("B132"), ("B133"), ("B134"), ("B135"), ("B136"), ("B137"), ("B138"), ("B139"), ("B140");

INSERT INTO VendorCategory (VendCatName) VALUES ("Aparrel"), ("Instruments"), ("Books"), ("Repair"), ("Body Art"), ("Entertainment Media"), ("Misc"), ("Food");

INSERT INTO VendorAssignment (SectionID, VendorName, Description, VisitorID, VendCatID) VALUES ("A01", "Accordion City Mega Mall", "Instrument store", 11, 2), ("A02", "Accordion City Mega Mall", "Instrument store", 11, 2), ("A03", "Accordion City Mega Mall", "Instrument store", 11, 2), ("A04", "Accordion City Mega Mall", "Instrument store", 11, 2), ("A05", "Accordion City Mega Mall", "Instrument store", 11, 2),
  ("A06", "My Other ATM", "ATM", NULL, 7),
  ("A07", "Malleus Malificarum Supplies", "Antiquarian books", 3, 3),
  ("A08", "Hammered Steel and Leather", "Custom iron-work fittings & clothes", 20, 1), ("A09", "Hammered Steel and Leather", "Custom iron-work fittings & clothes", 20, 1), ("A10", "Hammered Steel and Leather", "Custom iron-work fittings & clothes", 20, 1),
  ("A11", "Concertina Nation Super Store", "Instrument store", 2, 2), ("A12", "Concertina Nation Super Store", "Instrument store", 2, 2), ("A13", "Concertina Nation Super Store", "Instrument store", 2, 2), ("A14", "Concertina Nation Super Store", "Instrument store", 2, 2), ("A15", "Concertina Nation Super Store", "Instrument store", 2, 2),
  ("A16", "Nothing But Bagpipes!", "Instrument store", 27, 2), ("A17", "Nothing But Bagpipes!", "Instrument store", 27, 2), ("A18", "Nothing But Bagpipes!", "Instrument store", 27, 2),
  ("A19", "Digeridoo-wop Sound Stylists", "Instrument store", 29, 2), ("A20", "Digeridoo-wop Sound Stylists", "Instrument store", 29, 2), ("A21", "Digeridoo-wop Sound Stylists", "Instrument store", 29, 2),
  ("A22", "The Vinyl Antiquarian", "Old & current vinyl & tapes", 16, 6), ("A23", "The Vinyl Antiquarian", "Old & current vinyl & tapes", 16, 6),
  ("B26", "Patch the Bellows Fixer", "Instrument repair", 22, 4), ("B27", "Patch the Bellows Fixer", "Instrument repair", 22, 4), ("B28", "Patch the Bellows Fixer", "Instrument repair", 22, 4),
  ("B29", "Jim's DX Instrument Repair", "Instrument repair", 35, 4), ("B30", "Jim's DX Instrument Repair", "Instrument repair", 35, 4), ("B31", "Jim's DX Instrument Repair", "Instrument repair", 35, 4), ("B32", "Jim's DX Instrument Repair", "Instrument repair", 35, 4),
  ("B33", "Tattoos That Stay to Go", "Tattoos & piercings", 14, 5), ("B34", "Tattoos That Stay to Go", "Tattoos & piercings", 14, 5), ("B35", "Tattoos That Stay to Go", "Tattoos & piercings", 14, 5),
  ("A24", "Bob the CD Guy", "Old & current CDs & DVDs", 4, 6), ("A25", "Bob the CD Guy", "Old & current CDs & DVDs", 4, 6),
  ("B36", "Instruments You Never Knew Existed", "World music instruments", 38, 2), ("B37", "Instruments You Never Knew Existed", "World music instruments", 38, 2), ("B38", "Instruments You Never Knew Existed", "World music instruments", 38, 2),
  ("B39", "Jack in the Shruti Box", "World music instruments", 34, 2),
  ("B40", "The Future Isn't What it Used to Be", "Prepper supplies & literature", 18, 7), ("B41", "The Future Isn't What it Used to Be", "Prepper supplies & literature", 18, 7), ("B42", "The Future Isn't What it Used to Be", "Prepper supplies & literature", 18, 7),
  ("B43", "Little Gem Electronics Division", "Music, electronics, & repair", 31, 7), ("B44", "Little Gem Electronics Division", "Music, electronics, & repair", 31, 7), ("B45", "Little Gem Electronics Division", "Music, electronics, & repair", 31, 7),
  ("B46", "Books and More", "Books & music", 6, 7), ("B47", "Books and More", "Books & music", 6, 7),
  ("B48", "The Ink Spots", "Tattoos & piercings", 32, 5), ("B49", "The Ink Spots", "Tattoos & piercings", 32, 5),
  ("B50", "Footwear for the End of the World", "Custom footwear", 1, 1), ("B51", "Footwear for the End of the World", "Custom footwear", 1, 1), ("B52", "Footwear for the End of the World", "Custom footwear", 1, 1),
  ("B53", "Librus Umbrarum Rare Books", "Antiquarian books", 13, 3), ("B54", "Librus Umbrarum Rare Books", "Antiquarian books", 13, 3), ("B55", "Librus Umbrarum Rare Books", "Antiquarian books", 13, 3),
  ("B56", "Pavel and Jose's Taqueria", "Tacos and Borscht", 19, 8), ("B57", "Pavel and Jose's Taqueria", "Tacos and Borscht", 19, 8), ("B58", "Pavel and Jose's Taqueria", "Tacos and Borscht", 19, 8), ("B59", "Pavel and Jose's Taqueria", "Tacos and Borscht", 19, 8),
  ("B60", "The Cheating Vegan", "Omnivore fare, short order meals", 39, 8), ("B61", "The Cheating Vegan", "Omnivore fare, short order meals", 39, 8), ("B62", "The Cheating Vegan", "Omnivore fare, short order meals", 39, 8),
  ("B63", "Doom and Gloom!", "Prepper Supplies and Literature", 36, 7), ("B64", "Doom and Gloom!", "Prepper Supplies and Literature", 36, 7), ("B65", "Doom and Gloom!", "Prepper Supplies and Literature", 36, 7),
  ("B66", "Look the Part", "Custom Clothing", 37, 1), ("B67", "Look the Part", "Custom Clothing", 37, 1), ("B68", "Look the Part", "Custom Clothing", 37, 1), ("B69", "Look the Part", "Custom Clothing", 37, 1),
  ("B70", "Pampered Mutt", "Pet Supplies, Mutt Muffs", 40, 7), ("B71", "Pampered Mutt", "Pet Supplies, Mutt Muffs", 40, 7),
  ("B72", "The Unchained Spirit", "Custom Art, Watercolors, Stained Glass", 33, 7), ("B73", "The Unchained Spirit", "Custom Art, Watercolors, Stained Glass", 33, 7),
  ("B74", "Das Schnitzel Haus", "Sausage, Sandwiches, Snacks, Beer", 17, 8), ("B75", "Das Schnitzel Haus", "Sausage, Sandwiches, Snacks, Beer", 17, 8), ("B76", "Das Schnitzel Haus", "Sausage, Sandwiches, Snacks, Beer", 17, 8), ("B77", "Das Schnitzel Haus", "Sausage, Sandwiches, Snacks, Beer", 17, 8),
  ("B78", "Eine Kleine Knackwurst", "Sandwiches, Barbecue, Beer", 10, 8), ("B79", "Eine Kleine Knackwurst", "Sandwiches, Barbecue, Beer", 10, 8), ("B80", "Eine Kleine Knackwurst", "Sandwiches, Barbecue, Beer", 10, 8), ("B81", "Eine Kleine Knackwurst", "Sandwiches, Barbecue, Beer", 10, 8),
  ("B82", "Zur Krone West", "International Beer Hall", 23, 8), ("B83", "Zur Krone West", "International Beer Hall", 23, 8), ("B84", "Zur Krone West", "International Beer Hall", 23, 8), ("B85", "Zur Krone West", "International Beer Hall", 23, 8), ("B86", "Zur Krone West", "International Beer Hall", 23, 8),
  ("B87", "Just Like Late Night TV", "Misc. Goods 'As Advertised On TV'", 26, 7), ("B88", "Just Like Late Night TV", "Misc. Goods 'As Advertised On TV'", 26, 7), ("B89", "Just Like Late Night TV", "Misc. Goods 'As Advertised On TV'", 26, 7),
  ("B90", "Jimbo the Techie", "Tech Goodies and Repairs", 5, 4), ("B91", "Jimbo the Techie", "Tech Goodies and Repairs", 5, 4),
  ("B92", "Fried Stuff On Sticks", "Deep Fried Stuff on Sticks", 8, 8), ("B93", "Fried Stuff On Sticks", "Deep Fried Stuff on Sticks", 8, 8), ("B94", "Fried Stuff On Sticks", "Deep Fried Stuff on Sticks", 8, 8),
  ("B95", "Eat Cheese Or Die", "Cheese Curds, Beer, Pizza", 28, 8), ("B96", "Eat Cheese Or Die", "Cheese Curds, Beer, Pizza", 28, 8),
  ("B97", "Tour Collectibles", "Souvenirs of Music Tours", 15, 7), ("B98", "Tour Collectibles", "Souvenirs of Music Tours", 15, 7),
  ("B99", "The Convenient Shoppe", "Camping Supplies, Snacks, Toiletries", 21, 7), ("B100", "The Convenient Shoppe", "Camping Supplies, Snacks, Toiletries", 21, 7), ("B101", "The Convenient Shoppe", "Camping Supplies, Snacks, Toiletries", 21, 7), ("B102", "The Convenient Shoppe", "Camping Supplies, Snacks, Toiletries", 21, 7),
  ("B103", "My ATM", "ATM", NULL, 7),
  ("B104", "Kate's Kustom Keyboards", "Modifications & repair", 12, 4),
  ("B105", "The Portable Hangover", "Microbrew Beer Garden", 7, 8), ("B106", "The Portable Hangover", "Microbrew Beer Garden", 7, 8), ("B107", "The Portable Hangover", "Microbrew Beer Garden", 7, 8),
  ("B108", "A Cold One", "Ice Cream Shop", 30, 8), ("B109", "A Cold One", "Ice Cream Shop", 30, 8), ("B110", "A Cold One", "Ice Cream Shop", 30, 8), ("B111", "A Cold One", "Ice Cream Shop", 30, 8),
  ("B112", "Polished Wood and Custom Brass", "Custom Cabinetry and Fine Woodwork", 24, 7), ("B113", "Polished Wood and Custom Brass", "Custom Cabinetry and Fine Woodwork", 24, 7), ("B114", "Polished Wood and Custom Brass", "Custom Cabinetry and Fine Woodwork", 24, 7),
  ("B115", "The Metalsmith", "Hardware, Tools, Camping supplies", 9, 7), ("B116", "The Metalsmith", "Hardware, Tools, Camping supplies", 9, 7), ("B117", "The Metalsmith", "Hardware, Tools, Camping supplies", 9, 7), ("B118", "The Metalsmith", "Hardware, Tools, Camping supplies", 9, 7),
  ("B119", "Today's Accordionist", "Trade Journals", 25, 3)
;

INSERT INTO Stages (StageName) VALUES ("Concertina Corner"), ("Rockin' Out the Polkas"), ("Main Squeeze");

INSERT INTO Performers (PerformerName, BandMembers) VALUES ("Goat Cheese Pizza", "Chastity Shields, Violet Graham, Jerry Valez"),
  ("Squeeze Play", "Amir Welch, Nicholas Cortez, Mackenzie Clemons"),
  ("Bellows Benders", "Yoshi Horne, Xenos Murray, Hunter Langley"),
  ("Accordion to Hoyle", "Martin Hoyle, James Hoyle, Zena Higgens"),
  ("Have Another Beer", "Martin Fowler, Stone Hubert, Hoyt Baker"),
  ("Lynyrd Skynyrd Accordion Tribute", "Wyoming Poole, Austin Holland, Holmes Moody"),
  ("Led Bellows", "Adele Patel, Carson Stout, Cherokee Sosa"),
  ("Squeezebox Serenaders", "Kiona Pruitt, Cynthia Velasquez, Aretha Gay, Tana Palmer"),
  ("Sona Revisited", "Caleb Bass, Catherine Trujillo, Erasmus Merritt"),
  ("Funkadelions", "Ralph Parish, Justin Stanley, Tiger Rhodes, Nathaniel Molina"),
  ("Tennessee Ernie Toyota", "Ernie Donaldson"),
  ("Basket of Deplorables", "Malachi Rhodes, Dominic Hudson, Angelica Kerr, Iko Donaldson, Jeannette Bradley"),
  ("The Lorem Ipsums", "Oscar Griffith, Jared Calahan, Chadwick Morrow, Jaden Knapp"),
  ("Captain Keyboard and the Squeezettes", "Carlos Marx, Jada Carney, Cheyenne Arnold, Erica Hancock, Dierdre Willis"),
  ("Skydiving Elvis and the Accordion Impersonators", "Elvis Reed, Odysseus Benson, Yao Lambert"),
  ("Darth Polka", "Aristotle Allison"),
  ("Concertina Warriors", "Gail Castaneda, Tanner Cameron, Farrah Taylor"),
  ("Elderly Mutant Ninja Toads", "Darryl Waters, Lane Jiminez, Lars McKee, Denton Richards"),
  ("Barney Fife and the Drum Corps", "Barney Fife, Casim Lamb, Chad Arnold, Kieron Datsun, Brennon Brewer"),
  ("Chaos and the Death Star Polka", "Wayne House, Robert Bird, Kirby Flynn, Selma Petty"),
  ("Not Your Grandpa's Polka Band", "Phillip Sutton, Clayton Baird, Christos Dixon, Miles Selenez"),
  ("Ford Prefect Trio", "Baxter Warner, Beau Woodard, Drake Stevens"),
  ("All the Diodes on My Left Side", "Whoopi Rogers, Denton Jenson, Tad Berry"),
  ("Your Mileage May Vary", "Emily Simon, Angela Doyle, Kathleen McClain"),
  ("Bob's Your Uncle", "Bob Hatfield, Bobby Meyers, Robert Bryan, Robby Greene"),
  ("Four Horsemen of the the Apocalypse Jug Band", "Darren Burnett, Teagan Rollins, Davis Bowing, Maisie Frederick"),
  ("But Wait! There's More!", "Lucian Fernandez, Kaden Lynch, Idola Stephenson, Alexander Landry, Demetrius Rosallus"),
  ("Thor's Crescent Wrench", "Gunnar Lidstrom, Nickolas Holmstrom, Siri Cronwall"),
  ("Polka Fever", "Beau Hunt, Michael Norman, Keith Pate"),
  ("The Usual Gang of Idiots", "Eugene George, Oliver Cochran, Isaiah Kemp, Channing Dillard, Leroy Fuller"),
  ("Death and Destruction in 3/4 Time", "Lucius York, Molly Montgomery, Savannah Port, Midge Garza"),
  ("Bob Wills Meets Gene Simmons", "Bob Simmons, Gene Wills"),
  ("The Apolkalypse is Coming", "Joshua McCoy, Benjamin Gills, Jack Fletcher, Lenore Norton"),
  ("TCP and the Three-Way Handshake", "Terry Postlethwait, Mallory Morrow, Richard Pruitt, Fuller Sullivan"),
  ("Moonrise at Litha", "Ivy Joyce, Lana Fischer, Azalea Mills"),
  ("Contents May Have Settled", "Declan Griffin, Rowana Douglas, Mannix Riddle"),
  ("Bacon Lettuce and Potato", "Neil Pork, Ayana Cabbage, Roy O'Brian"),
  ("LMJ X11 and Back", "Griffith Sears, Rebecca McKee, Yvette Golden, Joy James"),
  ("The Middle Management Trio", "Seth Harrington, Amir Goode, Signe Dyer"),
  ("And You Thought It Couldn't Get Worse", "Martin Rollins, Brittney Waller, Raphael de la Cruz"),
  ("Major Spammeister and the Robocallers", "Lev Knoxx, Cameron Chase, Cameron Golden, Caleb Murphy, Teagan Cash"),
  ("Magneto Ignition", "Clyde Bartlett, Foster Rosales"),
  ("Schroedinger's Squeezebox and the Virtual Cats", "Solomon Sanchez, Dianna Livingston, Carolina Mooney, Carmen Patti Dotson"),
  ("Bubba and the Down Home Space Cadets", "Casey 'Bubba' Wilkins, Kendall Villarreal, Kristie Compton"),
  ("Gee Dad, It's A Wurlitzer", "Alfonso Chris Foley"),
  ("Nobody Expects The Spanish Inquisition", "Vaughan Camacho, Gage Rollins, Melvin Harring"),
  ("Monty PHP", "Marsha Berta Woodard, Dolores Evans, Brooks Le, Jeanie Martinez"),
  ("Berlin Wall and the Code Warriors", "Lenard Stanton Wilder, Taylor Briana Rodriguez, Harris Rowe"),
  ("Three to Go", "Rhea Preston, Myrtle Knight, Bret Ty Preston"),
  ("The Vintage Sounds", "Freddy Hill, Chuck Alisha Gonzales, Edward Aurora Roman"),
  ("Death Metal Polka", "Shari Burt Christensen, Darcy Dillon, Zane George Stephenson"),
  ("Accordions from Asgard", "Vera Strickland, Stephen Edward Contreras"),
  ("Escape Velocity", "Karen Lowe, Alfonso Ruiz, Leona Sellers"),
  ("Plaid Kryptonite", "Lottie Whitaker"),
  ("Polka Event Horizon", "Leola Callahan, Mollie Lambert"),
  ("Last Contact", "Darin Adrienne Torres, Wallace Noah Bishop, Hung Oliver, Liliana Laura Dudley, Terra Simpson"),
  ("Futhark", "Russ Tyson, Luella Brooke Hogan, Monica Knowles"),
  ("Sensory Overload", "Jared Curry, Chase Henderson, Aurora Gould"),
  ("Inflight Airframe Failure", "Grover Laverne Beard, Felecia Best"),
  ("On the way to Tarkio", "Jan Dennis, Hank Mcdowell, Hester Sheree Park"),
  ("Rana Pipiens", "Dorian Valencia, Irene Carney, Bianca Leigh Brown"),
  ("Underactive Imagination", "Naomi Cathryn Velazquez, Rae Rasmussen Keith, Dean Drake"),
  ("4000 Angstrom Units", "Letitia Glenn, Marcelo Mark, Lee Lucile Phelps, Tony Freeman"),
  ("The Morotai Moles", "Landon Oneil, Jacqueline Farmer, Selena Bradford"),
  ("Body of Proof", "Valeria Jean Banks, Mac Adams, Patty Contreras"),
  ("Infinite Mass and the Singularity", "Orval Field Parsons, Melva Fern Lamb, Lacey Cross, Brandon Kennedy"),
  ("Los Perritos", "Katrina Hubbard, Humberto Waller, Kent Harmon");

INSERT INTO PerformanceSchedule (PerformerID, StageID, StartTime) VALUES (1, 1, "2017-08-07 12:00:00"), (1, 2, "2017-08-11 14:00:00"), (1, 3, "2017-08-12 12:00:00"),
  (2, 1, "2017-08-07 14:00:00"), (2, 2, "2017-08-11 16:00:00"),
  (3, 1, "2017-08-07 16:00:00"), (3, 2, "2017-08-11 18:00:00"), (3, 3, "2017-08-12 14:00:00"),
  (4, 1, "2017-08-07 18:00:00"), (4, 2, "2017-08-11 20:00:00"),
  (5, 1, "2017-08-07 20:00:00"), (3, 2, "2017-08-11 22:00:00"), (3, 3, "2017-08-12 16:00:00"),
  (6, 1, "2017-08-07 22:00:00"), (6, 2, "2017-08-12 12:00:00"), (6, 3, "2017-08-08 16:00:00"),
  (7, 1, "2017-08-08 12:00:00"), (7, 2, "2017-08-12 14:00:00"), (7, 3, "2017-08-13 12:00:00"),
  (8, 1, "2017-08-08 14:00:00"), (8, 2, "2017-08-12 16:00:00"),
  (9, 1, "2017-08-08 16:00:00"), (9, 2, "2017-08-12 18:00:00"), (9, 3, "2017-08-11 22:00:00"),
  (10, 1, "2017-08-08 18:00:00"), (10, 2, "2017-08-12 20:00:00"),
  (11, 1, "2017-08-08 20:00:00"), (11, 2, "2017-08-12 22:00:00"), (11, 3, "2017-08-11 20:00:00"),
  (12, 1, "2017-08-08 22:00:00"), (12, 2, "2017-08-13 12:00:00"),
  (13, 1, "2017-08-09 12:00:00"), (13, 2, "2017-08-13 14:00:00"), (13, 3, "2017-08-11 18:00:00"),
  (14, 1, "2017-08-09 14:00:00"), (14, 2, "2017-08-13 16:00:00"),
  (15, 1, "2017-08-09 16:00:00"), (15, 2, "2017-08-13 18:00:00"), (15, 3, "2017-08-11 16:00:00"),
  (16, 1, "2017-08-09 18:00:00"), (16, 2, "2017-08-13 20:00:00"),
  (17, 1, "2017-08-09 20:00:00"), (17, 2, "2017-08-13 22:00:00"), (15, 3, "2017-08-11 14:00:00"),
  (18, 1, "2017-08-09 22:00:00"), (18, 3, "2017-08-12 20:00:00"),
  (19, 1, "2017-08-10 12:00:00"), (19, 3, "2017-08-11 12:00:00"),
  (20, 1, "2017-08-10 14:00:00"), (20, 3, "2017-08-10 22:00:00"),
  (21, 1, "2017-08-10 16:00:00"),
  (22, 1, "2017-08-10 18:00:00"), (22, 3, "2017-08-13 16:00:00"),
  (23, 1, "2017-08-10 20:00:00"),
  (24, 1, "2017-08-10 22:00:00"),
  (25, 1, "2017-08-11 12:00:00"), (25, 3, "2017-08-10 18:00:00"),
  (26, 1, "2017-08-11 14:00:00"), (26, 3, "2017-08-12 22:00:00"),
  (27, 1, "2017-08-11 16:00:00"), (27, 3, "2017-08-10 16:00:00"),
  (28, 1, "2017-08-11 18:00:00"),
  (29, 1, "2017-08-11 20:00:00"), (29, 3, "2017-08-10 14:00:00"),
  (30, 1, "2017-08-11 22:00:00"), (30, 3, "2017-08-13 14:00:00"),
  (31, 1, "2017-08-12 12:00:00"), (31, 3, "2017-08-10 12:00:00"),
  (32, 1, "2017-08-12 14:00:00"),
  (33, 1, "2017-08-12 16:00:00"), (33, 3, "2017-08-09 22:00:00"),
  (34, 1, "2017-08-12 18:00:00"),
  (35, 1, "2017-08-12 20:00:00"), (35, 3, "2017-08-09 20:00:00"),
  (36, 1, "2017-08-12 22:00:00"),
  (37, 1, "2017-08-13 12:00:00"), (37, 3, "2017-08-09 18:00:00"),
  (38, 1, "2017-08-13 14:00:00"), (37, 3, "2017-08-08 18:00:00"),
  (39, 1, "2017-08-13 16:00:00"), (39, 3, "2017-08-09 16:00:00"),
  (40, 1, "2017-08-13 18:00:00"),
  (41, 1, "2017-08-13 20:00:00"), (41, 3, "2017-08-09 14:00:00"),
  (42, 1, "2017-08-13 22:00:00"),
  (43, 2, "2017-08-07 12:00:00"), (43, 3, "2017-08-09 12:00:00"),
  (44, 2, "2017-08-07 14:00:00"),
  (45, 2, "2017-08-07 16:00:00"), (43, 3, "2017-08-08 22:00:00"),
  (46, 2, "2017-08-07 18:00:00"),
  (47, 2, "2017-08-07 20:00:00"), (43, 3, "2017-08-08 20:00:00"),
  (48, 2, "2017-08-07 22:00:00"),
  (49, 2, "2017-08-08 12:00:00"),
  (50, 2, "2017-08-08 14:00:00"), (50, 3, "2017-08-13 18:00:00"),
  (51, 2, "2017-08-08 16:00:00"),
  (52, 2, "2017-08-08 18:00:00"), (52, 3, "2017-08-13 20:00:00"),
  (53, 2, "2017-08-08 20:00:00"), (53, 3, "2017-08-08 14:00:00"),
  (54, 2, "2017-08-08 22:00:00"),
  (55, 2, "2017-08-09 12:00:00"), (55, 3, "2017-08-08 12:00:00"),
  (56, 2, "2017-08-09 14:00:00"),
  (57, 2, "2017-08-09 16:00:00"), (57, 3, "2017-08-07 22:00:00"),
  (58, 2, "2017-08-09 18:00:00"),
  (59, 2, "2017-08-09 20:00:00"), (59, 3, "2017-08-07 20:00:00"),
  (60, 2, "2017-08-09 22:00:00"), (60, 3, "2017-08-10 20:00:00"),
  (61, 2, "2017-08-10 12:00:00"), (60, 3, "2017-08-07 18:00:00"),
  (62, 2, "2017-08-10 14:00:00"),
  (63, 2, "2017-08-10 16:00:00"), (63, 3, "2017-08-07 16:00:00"),
  (64, 2, "2017-08-10 18:00:00"), (64, 3, "2017-08-13 22:00:00"),
  (65, 2, "2017-08-10 20:00:00"), (65, 3, "2017-08-07 14:00:00"),
  (66, 2, "2017-08-10 22:00:00"), (66, 3, "2017-08-12 18:00:00"),
  (67, 2, "2017-08-11 12:00:00"), (67, 3, "2017-08-07 12:00:00");

INSERT INTO TicketAssignment (TicketID, VisitorID, MerchID, DatePurchased, Paid, CheckedIn, LicensePlate, LicenseIssuedIn) VALUES
  (1, 1, 49, "2017-06-01", true, false, null, null), /* Week-long adult ticket for visitor 1, two people staying for the week */
  (2, 1, 49, "2017-06-01", true, false, null, null), /* Week-long adult ticket for visitor 1 */
  (3, 1, 52, "2017-06-01", true, false, 'DHX-1138', 'Ohio'), /* Week-long parking ticket for visitor 1 */
  (4, 2, 49, "2017-06-02", true, false, null, null), /* Week-long adult ticket for visitor 2, two parents and a kid staying for the week */
  (5, 2, 49, "2017-06-02", true, false, null, null), /* Week-long adult ticket for visitor 2 */
  (6, 2, 50, "2017-06-02", true, false, null, null), /* Week-long <12 ticket for visitor 2 */
  (7, 2, 54, "2017-06-02", true, false, '867-5309', 'Arizona'), /* Week-long RV parking ticket for visitor 2 */
  (8, 3, 4, "2017-06-03", true, false, null, null), /* Day adult ticket for visitor 3, one person staying for one day */
  (9, 3, 10, "2017-06-03", true, false, 'SO-SLNCE', 'Arizona'), /* Day VIP parking ticket for visitor 3 */
  (10, 4, 4, "2017-06-04", true, false, null, null), /* Day adult ticket for visitor 4, one person staying for two days */
  (11, 4, 4, "2017-06-04", true, false, null, null), /* Day adult ticket for visitor 4 */
  (12, 4, 13, "2017-06-04", true, false, null, null), /* Day camping ticket for visitor 4 */
  (13, 4, 13, "2017-06-04", true, false, null, null), /* Day camping ticket for visitor 4 */
  (14, 4, 8, "2017-06-04", true, false, 'CH8-M8', 'California'), /* Day parking ticket for visitor 4 */
  (15, 4, 8, "2017-06-04", true, false, 'CH8-M8', 'California'); /* Day parking ticket for visitor 4 */

INSERT INTO CampingAssignment (TicketID, CampingID) VALUES (1, "A01"), (2, "A01"), (4, "A08"), (5, "A08"), (6, "A08"), (12, "C01"), (13, "C01");