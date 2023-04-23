/* DB Snow Flakes Script */

let dbSnow = new Array()
let dbSnowFont = "Times"
let dbSnowSymbol = "&#10052;"
let dbMarginBottom
let dbMarginRight
let dbCoord = new Array()
let dbSway = new Array()
let dbMoveX = new Array()
let dbTimer

window.addEventListener('load', function() {

    for ( i = 0; i < dbSnowFlakesMaxNumber; i++ )
    {
        document.body.insertAdjacentHTML
        (
            'beforeend',
            "<span id='db_snowflake_" + i + "' style='user-select:none;position:fixed;top:-" + dbSnowFlakesMaxSize + "px'>" + dbSnowSymbol + "</span>"
        );
    }

    dbSnowInit();

});

function dbGetRandom(min, max) {
    return Math.floor ( Math.random() * (max - min) ) + min;
}

function dbSnowInit()
{
    dbMarginBottom = document.documentElement.clientHeight + 50
    dbMarginRight = document.body.clientWidth - 15

    for ( i = 0; i < dbSnowFlakesMaxNumber; i++ )
    {
        dbSnow[i] = document.getElementById("db_snowflake_" + i)
        dbSnow[i].style.fontFamily = dbSnowFont
        dbSnow[i].size = dbGetRandom ( dbSnowFlakesMaxSize, dbSnowFlakesMinSize )
        dbSnow[i].style.fontSize = dbSnow[i].size + 'px'
        dbSnow[i].style.color = dbSnowFlakesColors[ dbGetRandom ( dbSnowFlakesColors.length, 1 ) ]
        dbSnow[i].style.textShadow = dbSnowFlakesColors[ dbGetRandom ( dbSnowFlakesColors.length, 1 ) ]
        dbSnow[i].style.zIndex = 99999
        dbSnow[i].speed = dbSnowFlakesSpeed * dbSnow[i].size / 5
        dbSnow[i].posx = dbGetRandom ( dbMarginRight, dbSnow[i].size )
        dbSnow[i].posy = dbGetRandom ( dbMarginBottom, 2 * dbSnow[i].size )
        dbSnow[i].style.left = dbSnow[i].posx + 'px'
        dbSnow[i].style.top = dbSnow[i].posy + 'px'

        dbCoord[i] = 0
        dbSway[i] = Math.random() * 15
        dbMoveX[i] = 0.03 + Math.random() / 10
    }
    
    dbSnowAction()
}

function dbSnowAction()
{
    for ( i = 0; i < dbSnowFlakesMaxNumber; i++ )
    {
        dbCoord[i] += dbMoveX[i];
        dbSnow[i].posy += dbSnow[i].speed
        dbSnow[i].style.top = dbSnow[i].posy + 'px'
        dbSnow[i].style.left = dbSnow[i].posx + dbSway[i] * Math.sin(dbCoord[i]) + 'px';
        dbSnow[i].style.top = dbSnow[i].posy + 'px';

        if ( dbSnow[i].posy >= dbMarginBottom - 2 * dbSnow[i].size )
            dbSnow[i].posy = 0
        
        if ( parseInt (dbSnow[i].style.left) > ( dbMarginRight - 3 * dbSway[i] ) )
            dbSnow[i].posx = dbGetRandom ( dbMarginRight , dbSnow[i].size )
    }

    dbTimer = setTimeout("dbSnowAction()", 50)
}