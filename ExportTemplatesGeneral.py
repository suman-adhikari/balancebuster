#!/usr/bin/python
# -*- coding: utf-8 -*-
import datetime
import sys, json

import xlsxwriter
from ExcelRepo import ExportRepo
argumentList = sys.argv

filename=argumentList[1] if len(argumentList) > 1 else None
dateFrom=argumentList[2] if len(argumentList) > 2 else None
dateTo=argumentList[3] if len(argumentList) > 3 else None
expName=argumentList[4] if len(argumentList) > 4 else None
interval=argumentList[5] if len(argumentList) > 5 else None

exportRepo = ExportRepo("192.168.0.6", "root", "", "expdb","utf8")
data = exportRepo.GetDataGeneral(dateFrom,dateTo,expName,interval)
count = str(len(data))

#print len(data)
#sys.exit()


workbook = xlsxwriter.Workbook(filename)
worksheet = workbook.add_worksheet()
bold = workbook.add_format()
headerBorderFormat = workbook.add_format({'border': True, 'border_color': '#000000', 'bold': 1,'bg_color': '#E3E3E3'})
borderFormat = workbook.add_format({'border': True, 'border_color': '#000000'})
backgroundFormat= workbook.add_format({'bg_color':'white'})
dateFormat = workbook.add_format({'num_format': 'yyyy-mm-dd'})

if(interval=="Yearly"):
    datecolumnFormat = workbook.add_format({'border': True, 'border_color': '#000000'})
else:
    datecolumnFormat = workbook.add_format({'border': True, 'border_color': '#000000', 'num_format': 'yyyy-mm-dd'})


worksheet.set_column('A:A', 10)
worksheet.set_column('B:B', 10)
#worksheet.set_column('D:E', 10)

worksheet.write('D1', unicode(expName, 'utf-8'), headerBorderFormat)
worksheet.write('A1', unicode("Date", 'utf-8'), headerBorderFormat)
worksheet.write('B1', unicode("Price", 'utf-8'),headerBorderFormat)


x=2

for row in data:
    worksheet.write('A' + str(x), row["Date"],datecolumnFormat)
    worksheet.write('B' + str(x), row["Price"],borderFormat)
    x += 1


# Create a new chart object. In this case an embedded chart.
chart_line = workbook.add_chart({'type': 'line'})
chart_column = workbook.add_chart({'type': 'column'})
chart_pie = workbook.add_chart({'type': 'pie'})

# Configure the LineChart
chart_line.add_series({
    'name':       '=Sheet1!$B$1',
    'categories': '=Sheet1!$A$2:$A$'+count,
    'values':     '=Sheet1!$B$2:$B$'+count,
    'marker': {'type': 'circle','size': 2},
    'line': {'width': 1,'color':'blue'},
    'smooth': True
})

chart_column.add_series({
    'name':       '=Sheet1!$B$1',
    'categories': '=Sheet1!$A$2:$A$'+count,
    'values':     '=Sheet1!$B$2:$B$'+count,
    'data_labels': {'value': True},
    'marker': {'type': 'circle','size': 2},
    'line': {'width': 1,'color':'blue'},
    'smooth': True
})


chart_line.set_title ({
    'name': 'Results of sample analysis',
})

chart_line.set_x_axis({
    'name': 'Date'
})
chart_line.set_y_axis({
    'name': 'Expenses',
    'major_gridlines':False
})

chart_line.set_drop_lines({
    'line': {'color': '#D3D3D3'}
})


# Set an Excel chart style. Colors with white outline and shadow.
chart_line.set_style(11)

# Insert the chart into the worksheet (with an offset).
worksheet.insert_chart('D5', chart_line,  {'x_scale': 2.5, 'y_scale': 2} )
worksheet.insert_chart('D35', chart_column,  {'x_scale': 2.5, 'y_scale': 2} )


workbook.close()
print("ExportSuccess")




