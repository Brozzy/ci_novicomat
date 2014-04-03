// JavaScript Document

angular.module('prispevek',[]).controller('PrispevekController',function() {
		this.Tags = "";
		this.Title = "";
		
		this.ResolveTitle = function title(Title) {
			this.Title = Title;
		}
		
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