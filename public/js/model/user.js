define(['exports','cute','common'], function(){
	Cute.Class.namespace("TKJ.user");	
	TKJ.user.show = function(){
		console.log(this);
	};
	return TKJ.user;
});