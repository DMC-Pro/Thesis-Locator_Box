package com.dmc.androidapp.rescueapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

/**
 * An example full-screen activity that shows and hides the system UI (i.e.
 * status bar and navigation/system bar) with user interaction.
 */
public class LoginActivity extends AppCompatActivity {

    EditText username;
    EditText password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        username = findViewById(R.id.editText);
        password = findViewById(R.id.editText2);

        findViewById(R.id.button).setOnClickListener(
                new View.OnClickListener()
                {
                    public void onClick(View view)
                    {
                        if(validate()){
                            Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                            startActivity(intent);
                            finish();
                        }
                    }
                }
        );
    }

    private boolean validate(){
        if(username.getText().toString().equals(GlobalVar.username) &&password.getText().toString().equals(GlobalVar.password)){
            return true;
        }
        else{
            return false;
        }
    }

}
