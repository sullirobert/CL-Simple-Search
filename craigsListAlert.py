import urllib2
import mechanize
import re
from bs4 import BeautifulSoup
import HTMLParser

#make a browser to fetch dom
br = mechanize.Browser()

site  = "http://boulder.craigslist.org/apa/index.rss"

response = br.open(site)
page  = response.read()
dom   = BeautifulSoup(page)
items = dom.find_all("item");


#parse the title for a price
def getPrice(item):
	
	text  = item.title.get_text()
	index = text.find('&#x0024;')
	if index > 0:
		numEnd = text[index:].find(" ")
		if numEnd > 0:
			rawPrice = text[ index + 8: index + numEnd ] 
			return int(rawPrice)

#look for "no pets"  or "Pets: No"
def getPetPolicy(item):
	text  = item.title.get_text()
	if text.find('no pets') >= 0:
		print "no pets"
		return False
	if text.find('Pets: No') >= 0:
		return "pets: no"
		return False

	return True

for item in items:
	price = getPrice(item)
	pets = getPetPolicy(item)
