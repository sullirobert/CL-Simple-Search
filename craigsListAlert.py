import urllib2
import mechanize
import re
from bs4 import BeautifulSoup
import HTMLParser
import dateutil
import datetime
import pytz
#make a browser to fetch dom
br = mechanize.Browser()

site  = "http://boulder.craigslist.org/apa/index.rss"
priceMax = 2000
priceMin = 1500



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
	if text.find('pets ok') >= 0:
		return True	
	elif text.find('no pets') >= 0:
		return False
	elif text.find('Pets: No') >= 0:
		return False
	else:
		return True


#return time since post
def getTimeSincePost(item):
	datestring  = item.find('dc:date').get_text()
	import dateutil.parser
	pubDate = dateutil.parser.parse(datestring)
	now = datetime.datetime.utcnow()
	tzNow = pytz.utc.localize(now)

	#need to adjust for time one
	delta = ( tzNow , pubDate )
	print delta

	#print date.date()
	#help(now)
	#print  ctime()


for item in items:
	price = getPrice(item)
	pets = getPetPolicy(item)
	getTimeSincePost(item)

	if pets:
		if price < priceMax and price > priceMin:
			print "in price range"


