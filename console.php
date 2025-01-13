<?php include 'backend/logger.php' ?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Консоль</title>
<style>
* {
  font-size: 18px;
  font-family: monospace;
}
body {
  text-align: center;
  color: #6f0;
  background-color: #222;
}
#central {
  width: 80%;
  margin-left: auto;
  margin-right: auto;
}
#form {
  background-color: #444;
  text-align: left;
  padding: 5px 0px 5px 10px;
}

#console {
  background-color: #222;
  margin: 3px;
  padding: 3px;
  color: #ee0;
  max-height: 700px;
  overflow: scroll;
}
input:focus {
  outline: none;
}
</style>
<script>
function newtonIteration(n, x0) {
        const x1 = ((n / x0) + x0) >> 1n;
        if (x0 === x1 || x0 === (x1 - 1n)) {
            return x0;
        }
        return newtonIteration(n, x1);
}

function divide(x, y) {
        if (x == y) {
          document.getElementById("output").innerHTML += "Это число простое!<br>";
        }
        factors_arr.push(y);
        document.getElementById("output").innerHTML += "<b>Найден множитель " + y + "!</b><br>";
        if (x != y) {
          document.getElementById("output").innerHTML += "Раскладываем число " + x/y + "...<br>";
        } else document.getElementById("output").innerHTML += "Процесс завершён! Фуууух, ну я и устал..<br>";
        return x/=y;
};

function factorize(x, y) {
        x = BigInt(x);
        while (x % 2n == 0n) x = divide(x, 2n);
        while (x % 3n == 0n) x = divide(x, 3n);
        var k = BigInt(y) % 6n;
        if (k == 1n) k = 2n;
        if (k == 5n) k = 1n;
        while (y*y <= x) {
            while (x % y == 0n) x = divide(x, y);
            y += (k*2n);
            k = (k%2n)+1n;
            if (y % 10000000n == 1) {
              document.getElementById("output").innerHTML += "Проверены все простые числа до " + y + " ("+ y*100n/newtonIteration(x, 1n) + "% всей работы)...<br>";
              return [x, y];
            };
        };
        if (x > 1) divide(x, x);
        factors += " " + factors_arr.join(" * ");
        factors_arr = [];
        return [];
};

function ExecFunc(func) {
    var res = [];
    if (!func) return "";
    if ( (func.includes("<")) || (func.includes(">")) ) {
		res.push("<span style='color: orange'>[WARNING]</span> Команда задержит опасные символы ('<' или '>') присутствие которых может навредить Вашему компьютеру..");
	};
	if (func == "status") {
       res.push("Работает");
    } else if (func == "help") {
       res.push("== Список доступных команд в консоли == ");
       res.push("== Игры == ");
       res.push("<b style='color: purple'>hack</b>: симуляция взлома");
       res.push("== Кибер-безопасность == ");
       res.push("<b style='color: purple'>status</b>: статус сервера");
       res.push("== Математика == ");
       res.push("<b style='color: purple'>factor [число]</b>: Разложить число на множители");
       res.push("== Другие команды ==");
       res.push("<b style='color: purple'>help</b>: Информация про команды");
       res.push("<b style='color: purple'>clear</b>: Очистить экран");
    } else if (func == "clear") {
       res.push("WHF@<?=$account?>: ")
    } else if (func == "hack") {
       res.push("<span style='color: white'>[LOG]</span> Начинаем взлом!");
       let i = Math.round(Math.random() * 500) + 500;
       for (j = 0; j < i; j++) {
           res.push("<span style='color: white'>[LOG]</span> Проверяем пароль <span style='color: #93f'>" + (Math.random()+"").split(".")[1] + "</span>.."); 
       };
       res.push("<span style='color: white'>[LOG]</span> Консоль успешно взломана, теперь там открылись пасхалки! :)");
    } else if (func.split(" ")[0] == "factor") {
          let x = func.split(" ")[1];
          if (x-0 != x) {
             res.push("<span style='color: red'>[ERROR]</span> Эта команда работает только с <b>числами</b>!");
          } else if ((x-0) <= 1) {
             res.push("<span style='color: red'>[ERROR]</span> Числа меньше чем 2 нельзя разложить на множители!");
          } else {
             x = BigInt(x);
             var y = BigInt("5");
             factors = x + " =";
             let p = document.createElement("span");
             p.id = "output";
             p.style.color = "white";
             document.getElementById("console").appendChild(p);
             p.innerHTML = "<br><big><b>Начинаю работу!</b></big><br>Раскладываем число " + x + "...<br>";
			 var i = setInterval( function () {
          		 s = factorize(BigInt(x), y);
          		 if (!s[0]) {
					document.getElementById("output").remove();
					document.getElementById("msgs").innerHTML = document.getElementById("msgs").innerHTML + "<span style='color: #6f0'>" + func + "</span><br><span style='color: blue'>" + factors + "</span><br>WHF@<?=$account?>: ";
                    factors = '';
                    clearInterval(i); 
                 };
          		 y = s[1];
          		 x = s[0];
          		 console.log(x, y);
                 document.getElementById("console").scrollTop = document.getElementById("console").scrollHeight;
             }, 50);
          };
    } else res.push("<span style='color: red'>[ERROR]</span> Команда не найдена. Попробуйте написать \"help\"");
    return res.join("<br>");
}
</script>
</head>
<body>
<div id='central'>
<br>
<div id='form'>
<p style='color: #ee0000'>Внимание! Пожалуйста, не пытайтесь взломать систему!</p>
<div id='console'>
<span id='msgs'>
<span style='color: white'>[LOG]</span><span style='color: blue'> Загружаем консоль..</span> <br>
<span style='color: #0d0'>[INFO]</span><span style='color: blue'> Версия 1.0.0, все права защищены.</span><br>
<span style='color: #0d0'>[INFO]</span><span style='color: blue'> <b>Данная программа не совершает никаких противозаконных действий, это всё лишь симуляция</b>.</span><br>
WHF@<?=$account?>: 
</span><input id='command' style='border: 0px; background-color: #222; color: #6f0; width: 80%' autofocus="1">
</div>
</div>
</div>
<script>
var s = [];
var factors = '';
var factors_arr = [];
window.addEventListener('keypress', event => {
  if (event.keyCode == 13) {
	 let func = document.getElementById("command").value;
     let res = ExecFunc(func);
     if (!factors) {
 	    if (func != "clear") res = document.getElementById("msgs").innerHTML + "<span style='color: #6f0'>" + func + "</span><br><span style='color: blue'>" + res + "</span><br>WHF@<?=$account?>: ";
 	    document.getElementById("msgs").innerHTML = res;
     };
     document.getElementById("command").value = '';
     document.getElementById("console").scrollTop = document.getElementById("console").scrollHeight;
  };
})
</script>
</body>
</html>