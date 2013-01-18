Fußi - Table Football Tracking
==============================

Fußi allows you to track the results of table football matches. Each month a
new league is started where each player has to play against every other player.
All game results are archived. With Fußi you can view the result and statistics
of all past leagues.

Fußi is currently in an early stage of development. Current features:

- Enter match data
- View matches of the current and past months
- View ranking of the current and past months

Setup
=====

1. Clone the repository to your harddisk
2. Run composer update to fetch all dependencies
3. Create a database (vendor/bin/doctrine-module orm:schema-tool:create)
4. Chown/chmod ./data/db and ./data/db/db.sqlite for the webserver user to be writable
5. Set up a webserver (e.g. php -S localhost:8080 -t public from project root)
6. Make sure php.ini has short_open_tags set to On
7. Open Fußi in your browser (http://localhost:8080)
8. Add players and enter some match data

Hacking
=======

Feel free to fork Fußi and add cool new features! See the list of issues for some inspiration ;)
