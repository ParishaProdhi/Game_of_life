#include <iostream>

using namespace std;

int main()
{
    int x, y;
    cin>>x>>y;
    int grid[x][y];
    for(int i=0; i<x; i++)
    {
        for(int j=0; j<y; j++)
        {
            cin>>grid[i][j];
        }
    }
    int newGenGrid[x][y];
    int generation;
    cin>>generation;
    int k=0;
    while(k<generation)
    {
        cout<<"____________________"<<k+1<<"th generation______________________"<<endl;
        for(int i=0; i<x; i++)
        {
            for(int j=0; j<y; j++)
            {
                int count = 0;
                if(grid[i-1][j-1] == 1 && (i-1)>=0 && (j-1)>=0 && (i-1)<x && (j-1)<y)
                {
                    count++;
                }

                if(grid[i-1][j] == 1 && (i-1)>=0 && (j)>=0 && (i-1)<x && (j)<y)
                {
                    count++;
                }

                if(grid[i-1][j+1] == 1 && (i-1)>=0 && (j+1)>=0 && (i-1)<x && (j+1)<y)
                {
                    count++;
                }

                if(grid[i][j-1] == 1 && (i)>=0 && (j-1)>=0 && (i)<x && (j-1)<y)
                {
                    count++;
                }

                if(grid[i][j+1] == 1 && (i)>=0 && (j+1)>=0 && (i)<x && (j+1)<y)
                {
                    count++;
                }

                if(grid[i+1][j-1] == 1 && (i+1)>=0 && (j-1)>=0 && (i+1)<x && (j-1)<y)
                {
                    count++;
                }

                if(grid[i+1][j] == 1 && (i+1)>=0 && (j)>=0 && (i+1)<x && (j)<y)
                {
                    count++;
                }

                if(grid[i+1][j+1] == 1 && (i+1)>=0 && (j+1)>=0 && (i+1)<x && (j+1)<y)
                {
                    count++;
                }

                newGenGrid[i][j]=(count== 3) ? 1:0 ;
                count = 0;
            }

        }
        cout<<endl;
        for(int i=0; i<x; i++)
        {
            for(int j=0; j<y; j++)
            {
                cout<<newGenGrid[i][j]<<" ";
            }
            cout<<endl;
        }
        for(int i=0;i<x;i++){
            for(int j=0;j<y;j++){
                grid[i][j]=newGenGrid[i][j];
            }
        }
        k++;
    }

    return 0;
}
