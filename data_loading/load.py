import urllib.request
import math

#API = "https://www.tycho.pitt.edu/api/query?apikey=3e865780e7b9c872a1d0&ConditionName=Measles&CountryISO=US&PartOfCumulativeCountSeries=0"
API = "https://www.tycho.pitt.edu/api/query?apikey=3e865780e7b9c872a1d0&ConditionName=Measles&CountryISO=US"
RECORDS = 500000
LIMIT = 20000
BLOCKS = math.ceil(RECORDS / LIMIT)
REMAINDER = RECORDS % LIMIT

print("Downloading", RECORDS, "records, with limit of", LIMIT, ", in", BLOCKS, "blocks.", "\n")

content = ""

for i in range(BLOCKS):
    offset = LIMIT * i
    url = ""

    if i < BLOCKS - 1:  # Not last block, download the minimum of records or limit
        url = API + "&limit=" + str(min(RECORDS, LIMIT)) + "&offset=" + str(offset)
    else:               # Last Block, only download remaining records
        url = API + "&limit=" + str(REMAINDER) + "&offset=" + str(offset)

    print(i + 1, "Downloading record", offset, "to", offset + LIMIT, end='')
    req = urllib.request.urlopen(url)
    print("..........", end='')
    temp = req.read().decode('utf8')

    if temp == "No results\n":
        print("No results")
        break  # Finished downlaoding data set

    if i > 0:   # Remove header from second to last block
        content += temp.split("\n", 1)[1]
    else:       # Do not remove header from first block
        content += temp

    print("done")

print("\nNumber of lines: ", content.count('\n'))

print("\nWriting to file..........", end='')

outfile = open('dataset.csv', 'w')
outfile.write(content)
outfile.close()

print("finished")
