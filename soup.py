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

def getPrice(item):
	
	text  = item.title.get_text()
	index = text.find('&#x0024;')
	if index > 0:
		numEnd = text[index:].find(" ")
		if numEnd > 0:
			rawPrice = text[ index + 8: index + numEnd ] 
			return int(rawPrice)

def getPetPolicy(item):
	print "o"

for item in items:
	price = getPrice(item)
