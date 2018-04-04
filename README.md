To deploy project on u'r server, first of all u need go to the project folder in console and write

    ./init
    
After init u need to install and update composer, then write u db connection data to common/config/main-local
and execute migrations and call actionInit from DefaultDataController,
to add default data to database.