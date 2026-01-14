ALTER TABLE segmentation_results
DROP FOREIGN KEY fk_seg_customer;

ALTER TABLE customers
PARTITION BY HASH(customer_id)
PARTITIONS 8;
