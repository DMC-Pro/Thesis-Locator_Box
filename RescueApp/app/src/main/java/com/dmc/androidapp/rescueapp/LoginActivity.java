package com.dmc.androidapp.rescueapp;

import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;

import org.json.JSONException;
import org.json.JSONObject;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;

import java.io.IOException;

public class LoginActivity extends AppCompatActivity {

    EditText usernameTextField;
    EditText passwordTextField;
    EditText localhostwifi;
    ProgressBar loading;
    private TextView resultTextView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        usernameTextField = findViewById(R.id.editText);
        passwordTextField = findViewById(R.id.editText2);
        resultTextView = findViewById(R.id.textView2);

        loading = findViewById(R.id.progressBar3);
        loading.setVisibility(View.INVISIBLE);

        localhostwifi = findViewById(R.id.editText3);
        GlobalVar.localhostwifi = localhostwifi.getText().toString();

        findViewById(R.id.button).setOnClickListener(
                new View.OnClickListener()
                {
                    public void onClick(View view)
                    {
                        resultTextView.setText("");
                        loading.setVisibility(View.VISIBLE);
                        GlobalVar.localhostwifi = localhostwifi.getText().toString();
                        new Login().execute(usernameTextField.getText().toString(),
                                                passwordTextField.getText().toString());
                    }
                }
        );

        findViewById(R.id.button2).setOnClickListener(
                new View.OnClickListener()
                {
                    public void onClick(View view)
                    {
                        Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                        startActivity(intent);
                        finish();
                    }
                }
        );
    }

    private class Login extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            final StringBuilder builder = new StringBuilder();
            try {
                Document doc = Jsoup.connect( "http://" + GlobalVar.localhostwifi + "/thesis/conn/")
                        .data("action", "login")
                        .data("user", params[0])
                        .data("pass", params[1])
                        .userAgent("Mozilla")
                        .post();
                builder.append(doc.getElementsByTag("body").text());
                return builder.toString();
            } catch (IOException e) {
                e.printStackTrace();
                return "{\"message\" : \"error\" , \"error\" : \"" + e.getMessage() + "\"}";

            }
        }

        @Override
        protected void onPostExecute(String result) {
            try {
                GlobalVar.jsonObj = new JSONObject(result.toString());
                if(GlobalVar.jsonObj.getString("message").equals("error")){
                    GlobalVar.message = GlobalVar.jsonObj.getString("message");
                    GlobalVar.error =  GlobalVar.jsonObj.getString("error");
                }
                else if(GlobalVar.jsonObj.getString("message").equals("success")){
                    GlobalVar.message = GlobalVar.jsonObj.getString("message");
                    GlobalVar.rescue_team_name = GlobalVar.jsonObj.getString("rescue_team_name");
                    GlobalVar.rescue_team_current_task = GlobalVar.jsonObj.getString("rescue_team_current_task");
                }
                else{
                    GlobalVar.message = "error";
                    GlobalVar.error = "No json received.";
                }
            } catch (JSONException e) {
                e.printStackTrace();
                GlobalVar.message = "error";
                GlobalVar.error = e.getMessage();
            }
            super.onPostExecute(result);
            loading.setVisibility(View.INVISIBLE);
            if(GlobalVar.message.equals("error")){
                resultTextView.setText(GlobalVar.error);
            }
            else if(GlobalVar.message.equals("success")) {
                GlobalVar.RescuerUsername = usernameTextField.getText().toString();
                Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        }
    }
}
