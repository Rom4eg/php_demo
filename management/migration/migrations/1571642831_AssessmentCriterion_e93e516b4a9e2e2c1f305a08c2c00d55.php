    <?php
use \management\migration;

/** Migration class.
 *
 * Used for modifying tables schema and data.
 *
 * List of "Do not":
 * 1. don't ignore "backward" function.
 * 2. don't mix schema modification and data modification.
 *
 * @codeCoverageIgnore
 */
class Migration_1571642831_AssessmentCriterion_e93e516b4a9e2e2c1f305a08c2c00d55 extends migration\BaseMigration{

    /** Entry point for "migrate" command.
     *
     */
    protected function forward(){
        $q="DROP TABLE vtiger_rating";
        $this->query($q, []);

        $q="CREATE TABLE vtiger_rating(
                id int PRIMARY KEY AUTO_INCREMENT,
                rating_no varchar(50) NOT NULL,
                rating_date datetime NOT NULL,
                owner int NOT NULL,
                spcompany int NOT NULL,
                FOREIGN KEY(owner) REFERENCES vtiger_users(id) on delete CASCADE,
                FOREIGN KEY(spcompany) REFERENCES vtiger_organizationdetails(id) on delete CASCADE
            ) DEFAULT CHARSET=utf8";
        $this->query($q, []);

        $q="CREATE TABLE assessment(
                id int PRIMARY KEY AUTO_INCREMENT,
                q1_experience int not null default 1,
                q2_prices int not null default 1,
                q3_quality int not null default 1,
                q4_payment int not null default 1,
                q5_delivery int not null default 1,
                q6_warranty int not null default 1,
                q7_inspection int not null default 1,
                q8_complaint int not null default 1,
                q9_attitude int not null default 2,
                q10_equipment int not null default 1,
                update_date datetime default null,
                ratingid int default null,
                user int default null,
                crmid int NOT NULL,
                area varchar(20) NOT NULL,
                UNIQUE KEY (ratingid, crmid, area),
                FOREIGN KEY (crmid) REFERENCES vtiger_crmentity(crmid) ON DELETE CASCADE,
                FOREIGN KEY (user) REFERENCES vtiger_users(id) ON DELETE SET NULL,
                FOREIGN KEY (ratingid) REFERENCES vtiger_rating(id) ON DELETE CASCADE
            )";
        $this->query($q, []);
    }

    /** Entry point for "rollback" command.
     *
     */
    protected function backward(){
        $q = "DROP TABLE assessment";
        $this->query($q, []);
    }
}
