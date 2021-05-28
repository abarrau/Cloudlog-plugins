<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_pluginsext_table extends CI_Migration {

        public function up()
        {
            // Create table "pluginsext" //
            $this->dbforge->add_field(array(
                    'pluginsext_id' => array(
                            'type' => 'INT',
                            'constraint' => 5,
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                    ),
                    'pluginsext_name' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '250'
                    ),
                    'pluginsext_allow' => array(
                            'type' => 'INT',
                            'constraint' => 3,
                            'unsigned' => TRUE,
                            'auto_increment' => FALSE
                    ),
                    'pluginsext_config' => array(
                            'type' => 'TEXT',
                            'null' => TRUE
                    ),
                    'pluginsext_info' => array(
                            'type' => 'TEXT',
                            'null' => TRUE
                    ),
                    'pluginsext_migration' => array(
                            'type' => 'INT',
                            'constraint' => 5,
                            'unsigned' => TRUE,
                            'auto_increment' => FALSE
                    ),
            ));
            $this->dbforge->add_key('pluginsext_id', TRUE);
            $this->dbforge->create_table('pluginsext');
            
            // Create table "USER_pluginsext" //
             $this->dbforge->add_field(array(
                    'pluginsext_id' => array(
                            'type' => 'INT',
                            'constraint' => 5,
                            'unsigned' => TRUE,
                            'auto_increment' => FALSE
                    ),
                    'pluginsext_user_id' => array(
                            'type' => 'INT',
                            'constraint' => 5,
                            'unsigned' => TRUE,
                            'auto_increment' => FALSE
                    ),
                    'pluginsext_user_allow' => array(
                            'type' => 'INT',
                            'constraint' => 3,
                            'unsigned' => TRUE,
                            'auto_increment' => FALSE
                    ),
                    'pluginsext_params' => array(
                            'type' => 'TEXT',
                            'null' => TRUE
                    ),
                    'pluginsext_values' => array(
                            'type' => 'TEXT',
                            'null' => TRUE
                    ),
            ));
            $this->dbforge->create_table('pluginsext_users');           
        }

        public function down()
        {
                echo "not possible";
        }
}