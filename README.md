# stock-market-neural-network
A tinker toy for "forecasting" the next hour on the stock market.

# Usage

First initiate the sqlite datastore with `php cli.php app:init`;

Collect data on the stock ticker items that you are interested every minute, for example I use FTSE and Gold futures so I have a cron job set to execute `php cli.php stock:scrape "^FTSE" "GCQ16.CMX"`.

