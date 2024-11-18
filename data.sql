--
-- Table structure for table `Transaction`
--

CREATE TABLE `Transaction` (
  `PayID` int(11) NOT NULL,
  `username` text NOT NULL,
  `Authority` text NOT NULL,
  `Amount` text NOT NULL,
  `Status` text NOT NULL,
  `Message` text NOT NULL,
  `ref_id` text NOT NULL,
  `Date` text NOT NULL,
  `DatePayed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Indexes for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD PRIMARY KEY (`PayID`);

--
-- AUTO_INCREMENT for table `Transaction`
--
ALTER TABLE `Transaction`
  MODIFY `PayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;


