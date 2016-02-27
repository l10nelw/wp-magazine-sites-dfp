# Generates a csv file that can be imported into DFP to bulk-create ad units
# Ad unit codes are in this form: name_category_sizename e.g. Title_default_Leaderboard

# Edit CODE, NAME, SIZES and CATEGORIES as necessary:
#-----
CODE = 'Title'
NAME = 'Title'
SIZES = 'Leaderboard_728x90 MediumRect_300x250 Skinner_1580x700 HalfPage_300x600'.split()
CATEGORIES = 'default fashion beauty relationships food travel'.split() # default + Wordpress category slugs
#-----
# Normally CODE and NAME can be the same e.g. Title and Title.
# If you must recreate/reimport an ad unit, you have to use a different CODE e.g. Title2 and Title.
# This is because ad unit codes must be unique and no ad units can be deleted.

from collections import namedtuple

OUTPUT = 'adunits.csv'

CSV_COLUMNNAMES = '#Code,Name,Sizes,Description,Enabled for AdSense,Border Color,Title Color,Background Color,Text Color,URL Color,'\
	'Placements,Target Window,Ad Type,Target Platform,Mobile Platform,Labels'

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

SIZES = [ sizeNamedTuple(size) for size in SIZES ]
csv_body = [ ROW_TEMPLATE.format(code=CODE, name=NAME, category=category, size=size)
             for category in CATEGORIES
             for size in SIZES
           ]
csv_file = CSV_COLUMNNAMES + '\n' + '\n'.join(csv_body)

with open(OUTPUT, 'w') as f: f.write(csv_file)
print('Output:', OUTPUT)
