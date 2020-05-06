ALTER TABLE progresstab
ADD CONSTRAINT FK_progresstab_userid
FOREIGN KEY (userid) REFERENCES usertab(userid);