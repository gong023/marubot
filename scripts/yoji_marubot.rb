# coding: utf-8
require 'rubygems'
require 'net/https'
require 'twitter'
require 'oauth'
require 'json'
require 'pp'

class YojiMaru
    def initialize
        Twitter.configure do |config|
            config.consumer_key       = "iA6syG3GpvAksccRUmoAUg"
            config.consumer_secret    = "9kTijp0gabxwIPlJZrWSzZUYvbvtMrDvLrhplZbc"
            config.oauth_token        = "400941481-EB8ImJjBPNu81MMkheLnSxhWS9MOz9vANJkhCzm6"
            config.oauth_token_secret = "oQ6TvwpqrcsQaicMc8wbzVp4X5cskREQcovSoxW3E"
        end
    end

    def Members
        Twitter.list_members('geekmaru-member').attrs.each do |key, value|
            p key
        end
    end
end

p 'test'
YojiMaru.new.Members
