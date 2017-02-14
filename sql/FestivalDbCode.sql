DROP Database IF EXISTS Festival_DB;
CREATE DATABASE Festival_DB;
USE Festival_DB;


DROP TABLE IF EXISTS Visitors; 
CREATE TABLE Visitors (
VisitorID INT NOT NULL AUTO_INCREMENT,
FName VARCHAR(50) NOT NULL,
LName VARCHAR(50) NOT NULL,
Email VARCHAR(255) NOT NULL,
PhoneNumber VARCHAR(50),
Address VARCHAR(200),
City VARCHAR(60),
StateProvince VARCHAR(2),
Country VARCHAR(50),
PostalCode VARCHAR(50),
Comments VARCHAR(200),
PRIMARY KEY (VisitorID)

);

DROP TABLE IF EXISTS Tickets; 
CREATE TABLE Tickets (
TicketID INT NOT NULL AUTO_INCREMENT,
Name VARCHAR(30) NOT NULL,
Price DECIMAL(4,2) NOT NULL,
Description VARCHAR(200),
Maximum INT NOT NULL,
PRIMARY KEY (TicketID)

);

DROP TABLE IF EXISTS Parking; 
CREATE TABLE Parking (
ParkingID INT NOT NULL AUTO_INCREMENT,
Name VARCHAR(30) NOT NULL,
Price DECIMAL(4,2) NOT NULL,
Maximum INT NOT NULL,
PRIMARY KEY (ParkingID)

);

DROP TABLE IF EXISTS TicketAssignment; 
CREATE TABLE TicketAssignment (
TicketAssignmentID INT NOT NULL AUTO_INCREMENT,
VisitorID INT NOT NULL,
TicketID INT NOT NULL,
ParkingID INT NOT NULL,
TotalPrice DECIMAL(4,2) NOT NULL,
DatePurchased DATE NOT NULL,
Paid BOOLEAN,
FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID),
FOREIGN KEY (TicketID) REFERENCES Tickets(TicketID),
FOREIGN KEY (ParkingID) REFERENCES Parking(ParkingID),
PRIMARY KEY (TicketAssignmentID)

);

DROP TABLE IF EXISTS Users;
CREATE TABLE Users (
UserID INT PRIMARY KEY, 
Username VARCHAR(255) NOT NULL, 
Password VARCHAR(255) NOT NULL, 
AccessLevel INT NOT NULL
);

DROP TABLE IF EXISTS MerchandiseCategory; 
CREATE TABLE MerchandiseCategory (
MerchCatID INT PRIMARY KEY, 
MerchCatName VARCHAR(15) NOT NULL
);

DROP TABLE IF EXISTS Merchandise; 
CREATE TABLE Merchandise (
MerchID INT PRIMARY KEY, 
MerchName VARCHAR(25) NOT NULL, 
QtyMax INT NOT NULL, 
QtySold INT DEFAULT 0,
Price VARCHAR(7) NOT NULL, 
CategoryID INT NOT NULL, 
FOREIGN KEY (CategoryID) REFERENCES MerchandiseCategory(MerchCatID) 
);

DROP TABLE IF EXISTS PerformanceSchedule;
CREATE TABLE PerformanceSchedule (
ScheduleID INT PRIMARY KEY, 
Performer VARCHAR(25) NOT NULL, 
Stage VARCHAR(25) NOT NULL, 
PerformDate DATE NOT NULL, 
TimeFrame VARCHAR(15) NOT NULL
); 

DROP TABLE IF EXISTS VendorCategory; 
CREATE TABLE VendorCategory (
VendorCatID INT PRIMARY KEY, 
VendCatName VARCHAR(25) NOT NULL
);

DROP TABLE IF EXISTS VendorAssignment; 
CREATE TABLE VendorAssignment (
SectionID INT PRIMARY KEY, 
VendorName VARCHAR(50) NOT NULL, 
Description VARCHAR(50) NOT NULL, 
VisitorID INT NOT NULL, 
CategoryID INT NOT NULL, 
FOREIGN KEY (VisitorID) REFERENCES Visitors(VisitorID), 
FOREIGN KEY (CategoryID) REFERENCES VendorCategory(VendorCatID)
);

CREATE INDEX TicketID
ON Tickets (TicketID);

CREATE INDEX VisitorID
ON Visitors (VisitorID);

CREATE INDEX ParkingID
ON Parking (ParkingID);

CREATE INDEX mCat 
ON MerchandiseCategory(MerchCatName);

CREATE INDEX merName 
ON Merchandise(MerchName);

CREATE INDEX vendCat
ON VendorCategory(VendCatName);

CREATE INDEX vendName 
ON VendorAssignment(VendorName);