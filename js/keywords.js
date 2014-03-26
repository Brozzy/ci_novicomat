// JavaScript Document

angular.module('keywords',[]).controller('KeywordsController',function() {
		this.Tags = "";
	
		this.filterKeyWords = function filter(Tags) {
			if(Tags == " " || Tags == "" || typeof Tags == "undefined")
				this.Tags = "";
			else
				this.Tags = Tags.split(',');
		}
		
		this.Add = function AddKeyWord(Portal) {
			this.Tags = "";
		}
});