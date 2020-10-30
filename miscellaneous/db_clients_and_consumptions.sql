CREATE TABLE clients (
  address TEXT,
  code INTEGER
);

CREATE TABLE consumptions (
  code INTEGER,
  date DATE,
  consumption INTEGER
);

INSERT INTO clients (code, address) VALUES
  (1010, '120 ABC Barcelona'),
  (2468, 'S/N XYZ Murcia'),
  (4321, 'Mr 151022'),
  (1234, 'Mr 151021')
;

INSERT INTO consumptions (code, date, consumption) VALUES
  (1010, '2015-10-21', 25),
  (1010, '2015-10-22', 25),
  (2468, '2015-10-21', 60),
  (2468, '2015-10-22', 75),
  (4321, '2015-10-21', 60),
  (4321, '2015-10-22', 75),
  (4321, '2015-10-23', 60),
  (1234, '2015-10-21', 80),
  (1234, '2015-10-22', 75),
  (1234, '2015-10-23', 60)
;
