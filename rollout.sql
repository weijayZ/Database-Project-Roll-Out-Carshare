DROP DATABASE IF EXISTS Rollout;

CREATE DATABASE Rollout;

CREATE TABLE Customer(
    Customer_ID VARCHAR(10) NOT NULL,
    UserName VARCHAR(255) NOT NULL,
    Pass_word VARCHAR(255) NOT NULL,
    DriverLNum VARCHAR(20) NOT NULL,
    FirstName VARCHAR(15),
    LastName VARCHAR(15),
    Sex VARCHAR(1),
    DateBirth DATE,
    PhoneNum INT,
    cAddress VARCHAR(255),
    PostalCode VARCHAR(7),
    Email VARCHAR(255) NOT NULL,
    myLocation VARCHAR(6),
	  PRIMARY KEY (Customer_ID, myLocation),
    UNIQUE (UserName,DriverLNum)
);

CREATE TABLE Cars(
    Car_ID VARCHAR(6) NOT NULL,
    Insurance VARCHAR(20) NOT NULL,
    Make VARCHAR(10),
    Model VARCHAR(20),
    Year INT,
    Colour VARCHAR(10),
    VehicleType VARCHAR(10),
    Mileage INT,
    inUse BOOLEAN NOT NULL,
    placedLocation VARCHAR(6) NOT NULL,
    VehicleImage VARCHAR(255),
    itCondition VARCHAR(10),
	  PRIMARY KEY (Car_ID)
);

CREATE TABLE Scheduler(
    PickUpDate DATE NOT NULL,
    StartTime TIME NOT NULL,
    EndTime TIME NOT NULL,
    Duration INT NOT NULL,
    Customer_ID VARCHAR(10),
    placedLocation VARCHAR(6) NOT NULL,
    myLocation VARCHAR(6) NOT NULL,
    Car_ID VARCHAR(6),
    PRIMARY KEY (Customer_ID, Car_ID, Duration),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
    ON DELETE CASCADE,
	  FOREIGN KEY (Car_ID) REFERENCES Cars(Car_ID)
    ON DELETE CASCADE
);

CREATE TABLE Invoice(
    InvoiceNum VARCHAR(10) NOT NULL,
    DueDate DATE,
    Paid BOOLEAN,
    Balance INT,
    OverDue BOOLEAN,
    PrevBalance INT,
	  PRIMARY KEY (InvoiceNum)
);

CREATE TABLE Lease(
    LeaseID VARCHAR(10) NOT NULL,
    Duration INT,
    Price INT,
    Car_ID VARCHAR(6),
    InvoiceNum VARCHAR(10),
    Customer_ID VARCHAR (10),
  	PRIMARY KEY (LeaseID),
  	FOREIGN KEY (InvoiceNum) REFERENCES Invoice(InvoiceNum)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
    FOREIGN KEY (Customer_ID, Car_ID, Duration) REFERENCES Scheduler(Customer_ID, Car_ID, Duration)
    ON UPDATE CASCADE
    ON Delete CASCADE
);

CREATE TABLE Maintenance(
    StaffID VARCHAR(10) NOT NULL,
    StaffName VARCHAR(30),
    Username VARCHAR(255) NOT NULL,
    sPassword VARCHAR(255) NOT NULL,
    sAddress VARCHAR(255),
    PhoneNum INT,
    SinNum INT NOT NULL,
    sLocation VARCHAR(6),
    ServiceType VARCHAR(20),
    sDriverLicense VARCHAR(10) NOT NULL,
    PRIMARY KEY (StaffID),
    UNIQUE (StaffID, Username, SinNum, sDriverLicense)

);

CREATE TABLE Administrator(
    StaffID VARCHAR(10) NOT NULL,
    StaffName VARCHAR(30),
    Username VARCHAR(255)NOT NULL,
    sPassword VARCHAR(255) NOT NULL,
    sAddress VARCHAR(255),
    PhoneNum INT,
    SinNum INT NOT NULL,
    Position VARCHAR(10),
	  PRIMARY KEY (StaffID),
    UNIQUE (StaffID, Username, SinNum)
);

CREATE TABLE Maintained(
    StaffID VARCHAR(10),
    Car_ID VARCHAR(7),
    PRIMARY KEY (StaffID, Car_ID),
    FOREIGN KEY (StaffID) REFERENCES Maintenance(StaffID)
    ON DELETE CASCADE,
    FOREIGN KEY (Car_ID) REFERENCES Cars(Car_ID)
    ON DELETE CASCADE
);

CREATE TABLE Billed(
  Customer_ID VARCHAR(10),
  InvoiceNum VARCHAR(10),
  PRIMARY KEY (Customer_ID, InvoiceNum),
  FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
  ON DELETE CASCADE,
  FOREIGN KEY (InvoiceNum) REFERENCES Invoice(InvoiceNum)
  ON DELETE CASCADE

);


INSERT INTO Customer
VALUES('C000000001', 'BooBoo1', 'notapass1', '2313123122', 'Jacob', 'Rotli', 'M', '1991-01-25', 7781234111,
'6702 GladStone st', 'V5P 4E9', 'bbqLovers@gmail.com', '000001'),
('C000000002', 'itzJohnCena', 'youcantseeme', '495834958', 'John', 'Cena', 'M', '1986-02-17', 6048181038,
'9596 Ontario St', 'V0N 2Y9', 'wweFanatic@gmail.com', '000500'),
('C000000003', 'CandyTosser', 'sweetButNotReally', '534534534', 'Cindy', 'Jones', 'F', '1962-11-29', 5221217782,
'2004 Candy Ln', 'V7D 6X7', 'sweetsArentOnlyForKids@gmail.com', '000010'),
('C000000004', 'YasuoooooooMain', 'faceTheWindN00bs', '342342455', 'Troll', 'McTrollFace', 'M', '1926-02-14', 6046969696,
'1234 UnderBridge st', 'V8O 2P2', 'ROFLROFLROFL@gmail.com', '000001'),
('C000000005', 'EroMangaSensei', '2Kawaii2Live', '546464654', 'Sugmoi', 'loli', 'F', '1998-12-25', 4534534545,
'7930 Aniki st', 'V6U 5H7', 'Notice_Me_Senpai@gmail.com', '231232'),
('C000000006', 'Meek', 'sadsa', '546464654', 'tuutuu', 'wut', 'F', '1998-12-25', 4534534545,
'7930 Aniki st', 'V6U 5H7', 'asdi@gmail.com', '231232'),
('C000000007', 'Juniper', '2asde', '546464654', 'penner', 'Keper', 'F', '1998-12-25', 4534534545,
'7930 Aniki st', 'V6U 5H7', 'gsgdfgg@gmail.com', '231232'),
('C000000008', 'tachitoo', 'asdasdsa', '546464654', 'Jacobs', 'Smith', 'F', '1998-12-25', 4534534545,
'7930 Aniki st', 'V6U 5H7', 'jturth@gmail.com', '231232'),
('C000000009', 'jakethesnake', 'dasdasdsa', '546464654', 'Fred', 'John', 'F', '1998-12-25', 4534534545,
'7930 Aniki st', 'V6U 5H7', 'rtutyikjh,@gmail.com', '231232'),
('C000000010', 'user', 'user1', '546464654', 'Fred', 'John', 'F', '1998-12-25', 4534534545,
'7930 Aniki st', 'V6U 5H7', 'rtutyikjh,@gmail.com', '231232');

INSERT INTO Cars
VALUES('813XTH', '5466546446', 'Honda', 'Civic Si Type-R', '2017', 'Red', 'Sedan', 11760, true, '000001', 'image/civic.jpg', 'Excellent'),
('758BBQ', '9070596871', 'Toyota', 'Tacoma', '2015', 'Blue', 'Truck', 67000, false, '000002', 'image/Tacoma.jpg', 'Good'),
('123MKK', '8950696072', 'Toyota', 'Sienna', '2008', 'Bronze', 'Van', 101760, false, '000003', 'image/Sienna.jpg', 'Acceptable'),
('567CNN', '5466546446', 'Subaru', 'WRX STI', '2017', 'Blue', 'Sedan', 8000, true, '000004', 'image/brapppppp.jpg', 'Excellent'),
('231MUM', '5466546446', 'Ford', 'F-150 Raptor', '2015', 'Black', 'Truck', 12568, false, '000005', 'image/raptor.jpg', 'Poor'),
('123MUM', '5466546446', 'Ford', 'F-150 Raptor', '2015', 'Black', 'Truck', 12568, false, '000005', 'image/raptor.jpg', 'Poor'),
('124MUM', '5466546446', 'Ford', 'Fusion', '2015', 'Black', 'Sedan', 12568, false, '000002', 'image/fusion.jpg', 'Poor'),
('125MUM', '5466546446', 'Ford', 'Fusion', '2015', 'Black', 'Sedan', 12568, false, '000004', 'image/fusion.jpg', 'Poor'),
('126MUM', '5466546446', 'Jeep', 'Wrangler', '2015', 'Black', 'SUV', 12568, false, '000006', 'image/wrangler.jpg', 'Poor'),
('127MUM', '5466546446', 'Jeep', 'Wrangler', '2015', 'Black', 'SUV', 12568, false, '000010', 'image/wrangler.jpg', 'Poor'),
('128MUM', '5466546446', 'Mazda', 'Miata', '2015', 'Black', 'Coupe', 12568, false, '000015', 'image/miata.jpg', 'Poor'),
('129MUM', '5466546446', 'Mazda', 'Miata', '2015', 'Black', 'Coupe', 12568, false, '000060', 'image/miata.jpg', 'Poor'),
('120MUM', '5466546446', 'Subaru', 'BRZ', '2015', 'Black', 'Coupe', 12568, false, '000123', 'image/brz.jpg', 'Acceptable'),
('121MUM', '5466546446', 'Honda', 'Odyessy', '2015', 'Black', 'Van', 12568, false, '000124', 'image/odyessy.jpg', 'Acceptable'),
('619XRZ', '5466546446', 'Subaru', 'Crosstrek', '2015', 'Black', 'SUV', 12568, false, '000125', 'image/crosstrek.jpg', 'Acceptable'),
('618XRZ', '5466546446', 'Toyota', '4Runner', '2015', 'Black', 'SUV', 12568, false, '000126', 'image/4runner.jpg', 'Acceptable'),
('617XRZ', '5466546446', 'Audi', 'Q7', '2015', 'Black', 'SUV', 12568, false, '000127', 'image/q7.jpg', 'Acceptable'),
('616XRZ', '5466546446', 'Nissan', 'GT-R', '2015', 'Black', 'Coupe', 12568, false, '000128', 'image/gtr.jpg', 'Acceptable'),
('615XRZ', '5466546446', 'Dodge', 'Ram', '2015', 'Black', 'Truck', 12568, false, '000129', 'image/ram.jpg', 'Acceptable'),
('614XRZ', '5466546446', 'Mitsubishi', 'Lancer EVO X', '2015', 'Black', 'Sedan', 12568, false, '000120', 'image/lancer.jpg', 'Acceptable'),
('613XRZ', '5466546446', 'Oscar Mayber', 'Weiner Mobile', '2015', 'Black', 'Van', 12568, false, '000121', 'image/weiner.jpg', 'Acceptable');

INSERT INTO Scheduler
VALUES('2017-01-25', '11:00:00', '15:00:00', 4, 'C000000005', '000002', '231232', '758BBQ'),
('2017-11-10', '12:00:00', '13:00:00', 1, 'C000000001', '000001', '000001', '813XTH'),
('2017-01-25', '09:00:00', '12:00:00', 3, 'C000000002', '000003', '000500', '123MKK'),
('2017-01-25', '10:00:00', '15:00:00', 5, 'C000000003', '000005', '000010', '231MUM'),
('2017-01-25', '11:00:00', '16:00:00', 5, 'C000000004', '000004', '000001', '567CNN'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '758BBQ'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '123MKK'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '567CNN'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '231MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '123MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '124MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '125MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '126MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '127MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '128MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '129MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '120MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '121MUM'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '619XRZ'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '618XRZ'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '617XRZ'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '616XRZ'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '615XRZ'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '614XRZ'),
('2017-11-21', '12:30:00', '14:25:00', 5, 'c000000001', '000005', '000001', '613XRZ');

INSERT INTO Invoice
VALUES('X000000001', '2017-12-28', false, 100, false, 0),
('X000000002', '2018-01-29', false, 50, false, 0),
('X000000003', '2017-11-15', false, 100, true, 100),
('X000000004', '2017-12-11', true, 50, false, 0),
('X000000005', '2017-10-25', false, 100, true, 0);


INSERT INTO Administrator
VALUES('S000000001', 'Blake Lively', 'MuffinTopper', 'seeFoodEatFood', '1234 McMansion Ln', 7781230987, 777888989, 'Intern'),
('S000000002', 'Miyuzaki-San', 'Ghibli_Fanatic', 'TotoroIsLife', '5767 Nasaca Valley Rd', 6049899999, 645786970, 'Manager'),
('S000000003', 'Doug', 'TheDougler', '2Lame4Lifer', '6777 Undergrad St', 9892215757, 145362456, 'Associate'),
('S000000004', 'Bruno Mars', 'NotTheBestSinger', '24kgoldchyea', '2312 Sinclair Ln', 6041239876, 876945123, 'Associate'),
('S000000005', 'John Connor', 'RobotsAreEvil', 'illbebackbaby', '7687 Hunting St', 778029324, 869043023, 'Intern'),
('S000000006', 'John Connor', 'Admin', 'Admin', '7687 Hunting St', 778029324, 869043023, 'Admin');
INSERT INTO Lease
VALUES('L000000001', 4, 20, '758BBQ', 'X000000001', 'C000000005'),
('L000000002', 1, 5, '813XTH', 'X000000002', 'C000000001'),
('L000000003', 3, 15, '123MKK', 'X000000003', 'C000000002'),
('L000000004', 5, 25, '231MUM', 'X000000004', 'C000000003'),
('L000000005', 5, 25, '567CNN', 'X000000005', 'C000000004');

INSERT INTO Maintenance
VALUES('M000000001', 'Connor Mc', 'Fighter4ireland', 'fightymcfightface', '7685 51st st', 434423444, 123456789, '000001', 'Mechanic', '1234567890'),
('M000000002', 'Buu ', 'dbzBestFighter', 'everyoneturntocandy', '6546 Top St', 604546456, 978675643, '000500', 'Driver', '8675645342'),
('M000000003', 'Steven Jones', 'TimeIsRunning', 'gixxer123', '8697 Lark St', 9892215757, 145362456, '344578', 'Driver', '8273645321'),
('M000000004', 'Tom Danger', 'tryHarderbro', 'crammmftw', '4758 Downer Ln', 6041239876, 876945123,'000342', 'Cleaner', '9808765432'),
('M000000005', 'Timmy', 'PimpOnAWheelChair', 'timmytimmytimmayyyyy', '45345 Hunting St', 778029324, 869043023, '000500', 'Mechanic', '0987968759');

INSERT INTO Billed
VALUES('C000000001', 'X000000001'),
('C000000002', 'X000000003'),
('C000000003', 'X000000004'),
('C000000004','X000000003'),
('C000000005','X000000005');

INSERT INTO Maintained
VALUES('M000000005', '813XTH'),
('M000000001', '813XTH'),
('M000000002', '123MKK'),
('M000000003', '231MUM'),
('M000000004', '567CNN'),
('M000000005', '758BBQ'),
('M000000005', '123MKK'),
('M000000005', '567CNN'),
('M000000005', '231MUM'),
('M000000005', '123MUM'),
('M000000005', '124MUM'),
('M000000005', '125MUM'),
('M000000005', '126MUM'),
('M000000005', '127MUM'),
('M000000005', '128MUM'),
('M000000005', '129MUM'),
('M000000005', '120MUM'),
('M000000005', '121MUM'),
('M000000005', '619XRZ'),
('M000000005', '618XRZ'),
('M000000005', '617XRZ'),
('M000000005', '616XRZ'),
('M000000005', '615XRZ'),
('M000000005', '614XRZ'),
('M000000005', '613XRZ'),
('M000000001', '758BBQ'),
('M000000001', '123MKK'),
('M000000001', '567CNN'),
('M000000001', '231MUM'),
('M000000001', '123MUM'),
('M000000001', '124MUM'),
('M000000001', '125MUM'),
('M000000001', '126MUM'),
('M000000001', '127MUM'),
('M000000001', '128MUM'),
('M000000001', '129MUM'),
('M000000001', '120MUM'),
('M000000001', '121MUM'),
('M000000001', '619XRZ'),
('M000000001', '618XRZ'),
('M000000001', '617XRZ'),
('M000000001', '616XRZ'),
('M000000001', '615XRZ'),
('M000000001', '614XRZ'),
('M000000001', '613XRZ');
