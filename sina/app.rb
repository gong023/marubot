require 'sinatra'
require 'omniauth'
require 'omniauth-twitter'

enable :sessions

use OmniAuth::Builder do
    provider :twitter, '7ftDjPvDY2ofiHrqk9oXfA', 'OfMWdlR0Vl0XKu65u2chNHyFuF6DDNqIfKI0HJFEapA'
end

get '/marubot/sina' do
    erb :index
end

get '/auth/:provider/callback' do
    @auth = request.env['omniauth.auth']
    erb :home
end

__END__
@@layout
<!DOCTYPE html>
<html>
    <head>
        <title>Sinatra-OmniAuth</title>
    </head>
    <body>
        <%= yield %>
    </body>
</html>

@@index
<a href="/auth/twitter">Twitter でログイン</a>

@@home
<h1>Wellcome</h1>
<pre>
    <%= @auth %>
</pre>
