
#-----
code = 'HerWorld'
title = 'HerWorld'
sizes = 'Leaderboard_728x90 MediumRect_300x250 Skinner_1580x700 HalfPage_300x600'.split()
categories = 'Default Fashion Beauty SexMarriage Lifestyle Parenting'.split()
# Leaderboard_728x90 LargeLeader_970x90 MediumRect_300x250 Skinner_1580x700 HalfPage_300x600 
# fashion beauty relationships-sex food travel
#-----

from collections import namedtuple

CSV_COLUMNNAMES = '#Code,Name,Sizes,Description,Enabled for AdSense,Border Color,Title Color,Background Color,Text Color,URL Color,Placements,Target Window,Ad Type,Target Platform,Mobile Platform,Labels'

ROW_TEMPLATE = ','.join((
	'{code}_{category}_{size.name}', # #Code
	'{title} {category} {size.name}', # Name
	'{size.dims}', # Sizes
	'', # Description
	'no', # Enabled for AdSense
	'', # Border Color
	'', # Title Color
	'', # Background Color
	'', # Text Color
	'', # URL Color
	'{title} {category}', # Placements
	'_blank', # Target Window
	'image', #Ad Type
	'web', #Target Platform
	'', # Mobile Platform
	'', # Labels
))

def sizeNamedTuple(size):
	parts = size.split('_')
	return namedtuple('size', 'name dims')(*parts)

sizes = [ sizeNamedTuple(size) for size in sizes ]
csv_body = [ ROW_TEMPLATE.format(code=code, title=title, category=category, size=size) for category in categories for size in sizes ]
csv_file = CSV_COLUMNNAMES + '\n' + '\n'.join(csv_body)

with open('ADUNITS.CSV', 'w') as f:
	f.write(csv_file)