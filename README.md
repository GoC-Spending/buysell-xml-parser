# buysell-xml-parser

Simple parser to extract contracting data from searches conducted on <https://buyandsell.gc.ca>.

**NB**: The contract history dataset that powers Buyandsell is published by PWGSC/PSPC: <https://buyandsell.gc.ca/procurement-data/contract-history/download-contract-history-data>. If you want more comprehensive results and finer control over your search terms, it’s probably best to use that dataset directly. If, however, you want just to quickly get the contract metadata for a given search on Buyandsell, this tool will help you do that.

## Dependencies 

1. PHP 5.7+
2. Composer, which can be downloaded from <https://getcomposer.org/download/>

## Installation

1. Clone the repository.
2. In the folder, install the dependencies `composer install`

You're ready to go!

## Loading data

1. Enter search terms and filters at <https://buyandsell.gc.ca/procurement-data/search/site>
2. Download the feed linked by the RSS icon in the results (it caps at 250 contracts, so search/filter accordingly)
3. Rename the file `data.xml` and store it in the root of this repository

## Parsing

1. Run `composer parse`
2. The parsed data will be saved in `contracts.csv`
