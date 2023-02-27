// MIT License... Do what you want.

(function() {
'use strict';
var defaultColor = '#CCC';

function replaceImg(p) {
// this uses an object returned by getParams to build a canvas and returns a data:uri
	var canvas = document.createElement('canvas'),
	c = canvas.getContext("2d");
	canvas.width = p.w;
	canvas.height = p.h;
	c.rect(0,0,p.w,p.h);
	c.fillStyle = p.color;
	c.fill();
	var colorData = c.getImageData(0,0,1,1).data,
	brightness = (colorData[0]*.299) + (colorData[1]*.587) + (colorData[2]*.114),
	txtColor = (brightness<160) ? 'rgba(255,255,255,.6)' : 'rgba(0,0,0,.6)',
	crossColor = (brightness<160) ? 'rgba(255,255,255,.1)' : 'rgba(0,0,0,.1)';
	c.fillStyle = txtColor;
	c.strokeStyle = crossColor;
	c.moveTo(0,0); c.lineTo(p.w,p.h);
	c.moveTo(0,p.h); c.lineTo(p.w,0);
	c.stroke();
	c.textAlign = 'center';
	c.textBaseline = 'middle';
	c.font = 'bold 14pt sans-serif';
	c.fillText(p.w+' x '+p.h, p.w/2, p.h/2, p.w-10);
	c.font = '11pt sans-serif';
	c.textBaseline = 'bottom';
	c.fillText(p.alt, p.w/2, p.h-2, p.w-10);
	return canvas.toDataURL();
}

function getParams(imgStr) {
// this splits the placeholder://size/color/alt string and returns a more-usable object
	var atts = imgStr.split('/'),
	obj = {}
	if (atts[2]) {
		var size = atts[2].split('x');
		obj.w = size[0];
		obj.h = (size[1]) ? size[1] : size[0];
	}
	obj.color = (atts[3] && atts[3].match(/^[0-9a-f]{3}|[0-9a-f]{6}$/i)) ? '#'+atts[3] : defaultColor;
	obj.alt = (atts[4]) ? decodeURIComponent(atts[4]) : '';
	return obj;
}

var params,regex = /(^placeholder:\/\/.*$)/;

// IMG src
for (var src,imgs=document.getElementsByTagName('img'),i=imgs.length; i--;) {
	src = imgs[i].src.match(regex);
	if (src) {
		params = getParams(src[1]);

		if (!params.w) {
			params.w = imgs[i].width;
			params.h = imgs[i].height;
		}
		if (!params.alt) params.alt = imgs[i].alt;

		imgs[i].src = replaceImg(params)
	}
}

// srcsets
for (var src,srcset,srcimgs,setAtts=document.querySelectorAll('*[srcset]'),i=setAtts.length; i--;) {
	srcset = setAtts[i].getAttribute('srcset'),
	srcimgs = srcset.split(/\s*,\s*/);
	for (var s=srcimgs.length; s--;) {
		src = srcimgs[s].split(/\s+/)[0].match(regex);
		if (src) {
			params = getParams(src[1]);
			if (!params.alt) params.alt = setAtts[i].alt;

			srcimgs[s] = srcimgs[s].replace(src[1], replaceImg(params));
		}
	}
	setAtts[i].setAttribute('srcset', srcimgs.join())
}

regex = /(url\(.*(placeholder:\/\/[^'"\)]*).*\))/;

// url()s in stylesheets
for (var sheets=document.styleSheets,s=sheets.length; s--; ) {
	if (s) {
		for (var style,bg,content,r=sheets[s-1].cssRules.length; r--;) {
			style = sheets[s].cssRules[r].style;
			bg = style.backgroundImage.match(regex);
			content = style.content.match(regex);
			if (bg) {
				params = getParams(bg[2]);
				style.backgroundImage = 'url('+replaceImg(params)+')';
			}
			if (content) {
				params = getParams(content[2]);
				style.content = style.content.replace(content[1], 'url('+replaceImg(params)+')');
			}
		}
	}
}

// background images set inline
for(var inlStyle=document.querySelectorAll('*[style]'),bg,x=inlStyle.length; x--;) {
	bg = inlStyle[x].style.backgroundImage.match(regex);
	if (bg) {
		params = getParams(bg[2]);
		inlStyle[x].style.backgroundImage = 'url('+replaceImg(params)+')';
	}
}
})();