var timeOnGoing = setInterval(function(){ displayDate(); }, 1000);
var xHRObject;
if (window.XMLHttpRequest)
{
	xHRObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function agreementTextReadOnly() 
{
    document.getElementById("agreementText").readOnly = "true";
}

function registering(source, span, name, phone, gender, email, dateofbirth, homeunit, homestreet, homesuburb, username, password)
{
	var display = document.getElementById(span);
	var isOK = checkOK();
	if(isOK == 11)
	{
		var birthdate = dateofbirth.slice(0, 10);
		var birthtime = "00:00";
		var newbirthdatetime = birthdate + " " + birthtime + ":" + "00";
		var registerdatetime = getUTC();
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
		xHRObject.send("c-name=" + name + "&c-phone=" + phone + "&c-gender=" + gender + "&c-email=" + email + "&home-unit=" + homeunit + "&home-street=" + homestreet + "&home-suburb=" + homesuburb + "&c-dateofbirth=" + newbirthdatetime.toString() + "&l-username=" + username + "&l-password=" + password + "&register-datetime=" + registerdatetime);
	}
	else
	{
		if(document.getElementById("checkBirthDatetime").outerHTML != "<span id=\"checkBirthDatetime\"></span>")
		{
			display.innerHTML = "<font color='red'>Please fill all the (*) at first</font>";
		}
		else
		{
			display.innerHTML = "<font color='red'>Please change the default birth date</font>";
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

function checkAgreementCheckBox(span, checkBoxId)
{
  var display = document.getElementById(span);
  if(document.getElementById(checkBoxId).checked == false)
  {
    display.innerHTML = "<font color='red'>Can not empty</font>";
  }
  else
  {
    display.innerHTML = "<font color='green'>OK</font>";
  }
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

function displayDate() 
{
	document.getElementById("localDate").defaultValue = getUTC().slice(0, 10);
}

function cleanReuslt()
{
	document.getElementById("result").innerHTML = "";
	document.getElementById("checkName").innerHTML = "";
	document.getElementById("checkPhone").innerHTML = "";
	document.getElementById("checkGender").innerHTML = "";
	document.getElementById("checkEmail").innerHTML = "";
	document.getElementById("checkBirthDatetime").innerHTML = "";
	document.getElementById("checkHomeUnit").innerHTML = "";
	document.getElementById("checkHomeStreet").innerHTML = "";
	document.getElementById("checkHomeSuburb").innerHTML = "";
	document.getElementById("checkLoginUsername").innerHTML = "";
	document.getElementById("checkLoginPassword").innerHTML = "";
	document.getElementById("checkAgreement").innerHTML = "";
}