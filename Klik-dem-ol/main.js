function l(id){ return document.getElementById(id); };

// init game object
Game = {};

// player stats
Game.player = {
	
	cookies: 0,
	grandmas: 0,
	farms: 0,
	mines: 0,
	factorys: 0,
	clickers: 0,
	clickUp: 1
};

// autoload
if (localStorage.getItem("playerStatss") != null) {
	loadPlayer();
	displayAll();
};

// Click Handler
Game.cookieClick = function() {
	Game.player.cookies += 1 * Game.player.clickUp;
	l("vals").innerHTML = "Cookies: " + Math.round(Game.player.cookies);
};

// Buyer Handler
Game.handleBuy = {

	upgradeClick: function() {
		if (Game.player.cookies >= 10 * Game.player.clickUp){
			Game.player.cookies -= 10 * Game.player.clickUp;
			Game.player.clickUp += 0.25;
			// l("upgradeClick").style.removeProperty("opacity");
			l("clickUp").innerHTML = "Click Power: " + Game.player.clickUp;
			l("upgradeClick").innerHTML = "Upgrade Your Click!<br>Cost: " + 10 * Game.player.clickUp;
		};
	},

	buyClicker: function() {
		if (Game.player.cookies >= 10 * (Game.player.clickers+1)){
			Game.player.cookies -= 10 * (Game.player.clickers+1);
			Game.player.clickers++;
			l("clickers").innerHTML = "Clickers: " + Game.player.clickers + " (" + Game.valPs.clickersPs + " cps)";
			l("clicker").innerHTML = "Buy Clicker!<br>Cost: " + 10 * (Game.player.clickers+1);
		};
	},

	buyGrandma: function() {
		if (Game.player.cookies >= 500 * (Game.player.grandmas+1)){
			Game.player.cookies -= 500 * (Game.player.grandmas+1);
			Game.player.grandmas++;
			l("grandmas").innerHTML = "Grandmas: " + Game.player.grandmas + " (" + Game.valPs.grandmasPs + " cps)";
			l("grandma").innerHTML = "Buy Grandma!<br>Cost: " + 500 * (Game.player.grandmas+1);
		};
	},
	
	buyFarm: function() {
		if (Game.player.cookies >= 2000 * (Game.player.farms+1)){
			Game.player.cookies -= 2000 * (Game.player.farms+1);
			Game.player.farms++;
			l("farms").innerHTML = "Farms: " + Game.player.farms + " (" + Game.valPs.farmsPs + " cps)";
			l("farm").innerHTML = "Buy Farm!<br>Cost: " + 2000 * (Game.player.farms+1);
		};
	},

	buyMine: function() {
		if (Game.player.cookies >= 5000 * (Game.player.mines+1)) {
			Game.player.cookies -= 5000 * (Game.player.mines+1);
			Game.player.mines++;
			l("mines").innerHTML = "Mines: " + Game.player.mines + " (" + Game.valPs.minesPs + " cps)";
			l("mine").innerHTML = "Buy Mine!<br>Cost: " + 5000 * (Game.player.mines+1);
		};
	},

	buyFactory: function() {
		if (Game.player.cookies >= 10000 * (Game.player.factorys+1)){
			Game.player.cookies -= 10000 * (Game.player.factorys+1);
			Game.player.factorys++;
			l("factorys").innerHTML = "Factorys: " + Game.player.factorys + " (" + Game.valPs.factorysPs + " cps)";
			l("factory").innerHTML = "Buy Factory!<br>Cost: " + 10000 * (Game.player.factorys+1);
		};
	}
};

// Return Value and ValuePerSecond
Game.returnValue = function() {
	Game.player.cookies += 
		Game.player.clickers * Game.player.clickUp +
		Game.player.grandmas * 8 +
		Game.player.farms * 16 +
		Game.player.mines * 30 +
		Game.player.factorys * 50;
	l("vals").innerHTML = "Cookies: " + Math.round(Game.player.cookies);
};

Game.returnValPs = function() {
	Game.valPs = {
		clickersPs: Game.player.clickers * Game.player.clickUp,
		grandmasPs: Game.player.grandmas * 8,
		farmsPs:    Game.player.farms * 16,
		minesPs:    Game.player.mines * 30,		
		factorysPs: Game.player.factorys * 50
	};
	return Game.allPs = Game.valPs.clickersPs + 
						Game.valPs.grandmasPs + 
						Game.valPs.farmsPs +  							
						Game.valPs.minesPs + 
						Game.valPs.factorysPs,						//need a for in loop maybe...
	l("valsPs").innerHTML = "Per second: " + Game.allPs;
};

// Save / Load
function savePlayer() {
	localStorage.setItem("playerStatss", JSON.stringify(Game.player));
};

function loadPlayer() {
	if (localStorage.getItem("playerStatss") != null) {
		Game.player = JSON.parse(localStorage.getItem("playerStatss"));
	} else { alert("No file saved!") };
};

// Looop
window.setInterval(function() {
    Game.returnValue();
    Game.returnValPs();
}, 1000);

// display all (todo: dry!)
function displayAll() {
	l("vals").innerHTML = "Cookies: " + Math.round(Game.player.cookies);
	l("valsPs").innerHTML = "Per second: " + Game.allPs;
	l("clickUp").innerHTML = "Click Power: " + Game.player.clickUp;
	l("clickers").innerHTML = "Clickers: " + Game.player.clickers;
	l("grandmas").innerHTML = "Grandmas: " + Game.player.grandmas;
	l("farms").innerHTML = "Farms: " + Game.player.farms; 
	l("mines").innerHTML = "Mines: " + Game.player.mines; 
	l("factorys").innerHTML = "Factorys: " + Game.player.factorys;
};

// Refactor!!! DRY!!!!!!!!!!11111oneoneoneeleven