# Generates a csv file that can be imported into DFP to bulk create ad units
# Ad unit codes are in this form: name_category_sizename e.g. ZineTitle_default_Leaderboard

#-----
code = 'ZineTitle'
name = 'ZineTitle'
sizes = 'Leaderboard_728x90 MediumRect_300x250 Skinner_1580x700 HalfPage_300x600'.split()
categories = 'default fashion beauty relationships food travel'.split()
#-----

from collections import namedtuple

CSV_COLUMNNAMES = '#Code,Name,Sizes,Description,Enabled for AdSense,Border Color,Title Color,Background Color,Text Color,URL Color,Placements,Target Window,Ad Type,Target Platform,Mobile Platform,Labels'

ROW_TEMPLATE = ','.join((
	'{code}_{category}_{size.name}', # #Code
	'{name} {category} {size.name}', # Name
	'{size.dims}', # Sizes
	'', # Description
	'no', # Enabled for AdSense
	'', # Border Color
	'', # Title Color
	'', # Background Color
	'', # Text Color
	'', # URL Color
	'{name} {category}', # Placements
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
csv_body = [ ROW_TEMPLATE.format(code=code, name=name, category=category, size=size) for category in categories for size in sizes ]
csv_file = CSV_COLUMNNAMES + '\n' + '\n'.join(csv_body)

with open('ADUNITS.CSV', 'w') as f:
	f.write(csv_file)