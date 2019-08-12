function calendar(thisDate) {
	var toDate		= new Date();
	var toYear		= toDate.getFullYear();
	var toMonth		= toDate.getMonth() + 1;
	var toDays		= toDate.getDate();
	var toWeek		= toDate.getDay();
	var totalDate	= toYear + '' + dateFormat(toMonth) + '' + dateFormat(toDays);

	if (thisDate != null || thisDate != undefined) {
		toYear	= thisDate[0];
		toMonth	= thisDate[1];
	}

	var prevY = toYear;
	var prevM = toMonth - 1;
	var nextY = toYear;
	var nextM = toMonth + 1;

	if (toMonth == 1) {
		prevY -= 1;
		prevM  = 12;
	} else if (toMonth == 12) {
		nextY += 1;
		nextM  = 1;
	}

	var tmp = '';
	tmp += '<table cellspacing="0" cellpadding="0" border="0" class="cheader">';
	tmp += '<tr>';
	if (changebtn == 1) {
		tmp += '<td><a href="javascript:void(0);" onclick="calendar([' + prevY + ',' + prevM + ']);">&lt;&lt;</a></td>';
	}
	tmp += '<th>' + toYear + '年' + toMonth + '月' + '</th>';
	if (changebtn == 1) {
		tmp += '<td><a href="javascript:void(0);" onclick="calendar([' + nextY + ',' + nextM + ']);">&gt;&gt;</a></td>';
	}
	tmp += '</tr>';
	tmp += '<table cellspacing="0" cellpadding="0" border="0" class="cbody">';
	tmp += '<tr>';
	tmp += '<th>日</th>';
	tmp += '<th>月</th>';
	tmp += '<th>火</th>';
	tmp += '<th>水</th>';
	tmp += '<th>木</th>';
	tmp += '<th>金</th>';
	tmp += '<th>土</th>';
	tmp += '</tr>';

	var count = 0;

	for (var i = 1;i <= 31;i++) {
		var classAry = [];
		var classStr = '';

		var cDate	= new Date(toYear, toMonth - 1, i);
		var cYear	= cDate.getFullYear();
		var cMonth	= cDate.getMonth() + 1;
		var cDays	= cDate.getDate();

		if (cYear == toYear && cMonth == toMonth && cDays == i) {
			var cTotal	= cYear + '' + dateFormat(cMonth) + '' + dateFormat(cDays);
			var cWeek	= cDate.getDay();

			if (cWeek == 0) {
				tmp += '<tr>';
				count++;
				classAry.push('csun');
			} else if (cWeek == 6) {
				classAry.push('csat');
			}

			if (i == 1 && cWeek != 0) {
				count++;
				for (var j = 1;j <= cWeek;j++) {
					tmp += '<td>&nbsp;</td>';
				}
			}

			if (totalDate == cTotal) {
				classAry.push('ctodate');
			}

			if (classAry.length >= 1) {
				classStr = ' class="' + classAry.join(' ') + '"';
			}


			var temp = ("0" + i).slice(-2);

			tmp += '<td' + classStr + '><a href="#' + ("0" + cMonth).slice(-2) + i + '">' + i + '</a></td>';

			if (cWeek == 6) {
				tmp += '</tr>';
			}
		}
	}
	if (cWeek != 6) {
		var last = 6 - (cWeek);
		for (var k = 1;k <= last;k++) {
			tmp += '<td>&nbsp;</td>';
		}
		tmp += '</tr>';
	}
	count = 6 - count;
	if (count != 0) {
		for (var l = 1;l <= count;l++) {
			tmp += '<tr>';
			for (var m = 0;m < 7;m++) {
				tmp += '<td>&nbsp;</td>';
			}
			tmp += '</tr>';
		}
	}
	tmp += '</table>';

	document.getElementById('calendar').innerHTML = tmp;

	return false;
}

function dateFormat(str) {
	if (str < 10) {
		return '0' + str;
	} else {
		return str;
	}
}

window.onload = function() {
	calendar();
}
// 月の移動ボタンの有無[1 or 0]
var changebtn = 1;
