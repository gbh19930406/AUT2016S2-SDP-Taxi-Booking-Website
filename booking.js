var timeOnGoing = setInterval(function(){ displayDateTime(); }, 1000);
var typeInterval;
var seatInterval1;
var seatInterval2;
var updatetimeInterval;
function stopAllIntervals() { clearInterval(typeInterval); clearInterval(seatInterval1); clearInterval(seatInterval2); clearInterval(updatetimeInterval);}

var xHRObject;
if (window.XMLHttpRequest)
{
	xHRObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function booking(source, span, name, phone, type, seat, upunit, upstreet, upsuburb, updatetime, offunit, offstreet, offsuburb)
{
	var display = document.getElementById(span);
	var isOK = checkOK();
	if(isOK == 11)
	{
		var update = updatetime.slice(0, 10);
		var uptime = updatetime.slice(11, 16);
		var newupdatetime = update + " " + uptime + ":" + new Date().getSeconds();
		var bookdatetime = getUTC();
		xHRObject.open("POST", source, true);
		xHRObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xHRObject.onreadystatechange = function()
		{
			if ((xHRObject.readyState == 4) && (xHRObject.status == 200))
			{
				//cleanReuslt();
				var message = xHRObject.responseText;
				display.innerHTML = message;
			}
		};
		xHRObject.send("c-name=" + name + "&c-phone=" + phone + "&v-type=" + type + "&v-seat=" + seat + "&up-unit=" + upunit + "&up-street=" + upstreet + "&up-suburb=" + upsuburb + "&up-datetime=" + newupdatetime.toString() + "&off-unit=" + offunit + "&off-street=" + offstreet + "&off-suburb=" + offsuburb + "&book-datetime=" + bookdatetime);
	}
	else
	{
		if(document.getElementById("checkPickupDatetime").outerHTML != "<span id=\"checkPickupDatetime\"></span>")
		{
			display.innerHTML = "<font color='red'>Please fill all the (*) at first</font>";
		}
		else
		{
			display.innerHTML = "<font color='red'>Please change the default date and time</font>";
		}
	}
}

function inputValidate(source, span, data)
{
	var transfer = span + "=";
	var display = document.getElementById(span);
	if(data.trim() == "")
	{
		if(transfer.search("Unit") == -1)
		{
			display.innerHTML = "<font color='red'>Can not empty</font>";
		}
		else
		{
			display.innerHTML = "<font color='green'>OK</font>";
		}
	}
	else
	{
		xHRObject.open("POST", source, true);
		xHRObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xHRObject.onreadystatechange = function()
		{
			if ((xHRObject.readyState == 4) && (xHRObject.status == 200))
			{
				var message = xHRObject.responseText;
				display.innerHTML = message;
			}
		};
		xHRObject.send(transfer + data);
	}
	return display.innerHTML;
}

function inputValidateOfType(source, span1, span2, data1, data2)
{
	var display = document.getElementById(span1);
	if(data1.trim() == "")
	{
			display.innerHTML = "<font color='red'>Can not empty</font>";
	}
	else
	{
		xHRObject.open("POST", source, true);
		xHRObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xHRObject.onreadystatechange = function()
		{
			if ((xHRObject.readyState == 4) && (xHRObject.status == 200))
			{
				var message = xHRObject.responseText;
        if(message.search(" t") == -1)
          display.innerHTML = message.slice(0, 29);
        else
          display.innerHTML = message.slice(29);
			}
		};
		xHRObject.send(span1 + "=" + data1);
	}
	return display.innerHTML;
}

function inputValidateOfSeat(source, span1, span2, data1, data2)
{
	var display = document.getElementById(span2);
	if(data2.trim() == "")
	{
			display.innerHTML = "<font color='red'>Can not empty</font>";
	}
	else
	{
		xHRObject.open("POST", source, true);
		xHRObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xHRObject.onreadystatechange = function()
		{
			if ((xHRObject.readyState == 4) && (xHRObject.status == 200))
			{
				var message = xHRObject.responseText;
				if(message.search("Enter car type at first") == -1)
          display.innerHTML = message.slice(29);
        else
          display.innerHTML = message;
			}
		};
		xHRObject.send(span1 + "=" + data1 + "&" + span2 + "=" + data2);
	}
	return display.innerHTML;
}

function checkOK()
{
	var status = [];
	var spans = document.getElementsByTagName("span");
	for(i = 0; i < spans.length-1; i++)
	{
		status[i] = spans[i];
	}
	var count = 0;
	for(j = 0; j < status.length; j++)
	{
		var row = status[j].outerHTML;
		if(row.search("OK") != -1)
			count = count + 1;
	}
	return count;
}

function getUTC()
{
	var now = new Date();
	var month = (now.getMonth()+1).toString();
	if(month.length == 1)
	{
		month = "0" + month;
	}
	var date = (now.getDate()).toString();
	if(date.length == 1)
	{
		date = "0" + date;
	}
	var hour = (now.getHours()).toString();
	if(hour.length == 1)
	{
		hour = "0" + hour;
	}
	var minute = (now.getMinutes()).toString();
	if(minute.length == 1)
	{
		minute = "0" + minute;
	}
	var datetime = now.getFullYear().toString() + "-" + month + "-" + date + "T" + hour + ":" + minute;
	return datetime;
}

function displayDateTime() 
{
	document.getElementById("localDateTime").defaultValue = getUTC();
}

function cleanReuslt()
{
	document.getElementById("result").innerHTML = "";
	document.getElementById("checkName").innerHTML = "";
	document.getElementById("checkPhone").innerHTML = "";
	document.getElementById("checkType").innerHTML = "";
	document.getElementById("checkSeat").innerHTML = "";
	document.getElementById("checkPickupUnit").innerHTML = "";
	document.getElementById("checkPickupStreet").innerHTML = "";
	document.getElementById("checkPickupSuburb").innerHTML = "";
	document.getElementById("checkPickupDatetime").innerHTML = "";
	document.getElementById("checkDropoffUnit").innerHTML = "";
	document.getElementById("checkDropoffStreet").innerHTML = "";
	document.getElementById("checkDropoffSuburb").innerHTML = "";
}